<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use ArPHP\I18N\Arabic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use stdClass;
use Carbon\Carbon;

class PlayerControllerDev extends Controller
{
    public function index($token)
    {
        $date = new stdClass();
        $mosque = Mosque::wherePlayerToken($token)->first();

        if (!$mosque) {
            abort(404, 'Mosque not found');
        }

        $configPlayer = $mosque->configPlayers()->first();
        $configPlayerShow = $mosque->configPlayerShows()->first();
        $configPlayerInterval = $mosque->configPlayerIntervals()->first();

        // Get current month prayer data
        $prayerTimes = $this->getMonthlyPrayerTimes();

        // Process prayers configuration
        $prayers = $mosque->configPrayers()->where('is_prayer_time', 1);

        if ($configPlayer->with_imsak) {
            $prayers->orWhere(function($q) use ($mosque) {
                $q->where('mosque_id', $mosque->id)
                    ->where('name', 'imsak');
            });
        }

        if ($configPlayer->with_syuruq) {
            $prayers->orWhere(function($q) use ($mosque) {
                $q->where('mosque_id', $mosque->id)
                    ->where('name', 'syuruq');
            });
        }

        $prayers = $prayers->orderBy('order')->get();

        // Apply time adjustments to today's prayer times
        $todayKey = date('Y-m-d');
        if (isset($prayerTimes[$todayKey])) {
            foreach ($prayers as $prayer) {
                if (isset($prayerTimes[$todayKey][$prayer->name])) {
                    $baseTime = $prayerTimes[$todayKey][$prayer->name];
                    $adjustedTime = strtotime($baseTime) + ($prayer->time_adjustment * 60);
                    $prayer->time = date('H:i', $adjustedTime);
                } else {
                    $prayer->time = '00:00';
                }
            }
        }

        // Get images
        $images = $mosque->files()->where('type','like', 'image')->get();
        $marquees = $mosque->marquees;
        $backgrounds = $mosque->files()->where('type', 'background')->first();

        // Prepare dates
        $arabic = new Arabic();
        $now = time();
        $correction = $arabic->dateCorrection($now);
        $date->day = date('l');
        $date->georgian = date('d F Y');
        $date->hijri = $arabic->date('Y j, F', $now, $correction);

        // Prepare data status for cache checking
        $dataStatus = [
            'last_updated' => Cache::get('prayer_times_last_updated', time()),
            'current_month' => date('Y-m'),
            'cache_version' => $this->getCacheVersion()
        ];

        return view('users.players.indexdev', [
            'date' => $date,
            'prayers' => $prayers,
            'mosque' => $mosque,
            'images' => $images,
            'marquees' => $marquees,
            'backgrounds' => $backgrounds,
            'configPlayer' => $configPlayer,
            'configPlayerShow' => $configPlayerShow,
            'configPlayerInterval' => $configPlayerInterval,
            'token' => $token,
            'prayerTimes' => $prayerTimes,
            'dataStatus' => $dataStatus,
        ]);
    }

    /**
     * API endpoint untuk cek status data terbaru
     */
    public function checkDataStatus($token)
    {
        $mosque = Mosque::wherePlayerToken($token)->first();

        if (!$mosque) {
            return response()->json(['error' => 'Mosque not found'], 404);
        }

        $currentStatus = [
            'last_updated' => Cache::get('prayer_times_last_updated', time()),
            'current_month' => date('Y-m'),
            'cache_version' => $this->getCacheVersion(),
            'server_time' => time(),
            'formatted_time' => date('Y-m-d H:i:s')
        ];

        return response()->json([
            'status' => 'success',
            'data' => $currentStatus
        ]);
    }

    /**
     * API endpoint untuk mendapatkan prayer times terbaru
     */
    public function getPrayerTimes($token)
    {
        $mosque = Mosque::wherePlayerToken($token)->first();

        if (!$mosque) {
            return response()->json(['error' => 'Mosque not found'], 404);
        }

        try {
            $prayerTimes = $this->getMonthlyPrayerTimes();
            $prayers = $mosque->configPrayers()->where('is_prayer_time', 1)->orderBy('order')->get();

            // Apply adjustments to all days
            $adjustedPrayerTimes = [];
            foreach ($prayerTimes as $date => $times) {
                $adjustedPrayerTimes[$date] = [];
                foreach ($prayers as $prayer) {
                    if (isset($times[$prayer->name])) {
                        $baseTime = $times[$prayer->name];
                        $adjustedTime = strtotime($baseTime) + ($prayer->time_adjustment * 60);
                        $adjustedPrayerTimes[$date][$prayer->name] = date('H:i', $adjustedTime);
                    }
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'prayer_times' => $adjustedPrayerTimes,
                    'last_updated' => Cache::get('prayer_times_last_updated', time()),
                    'cache_version' => $this->getCacheVersion()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting prayer times: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get prayer times'], 500);
        }
    }

    /**
     * Get monthly prayer times with caching
     */
    private function getMonthlyPrayerTimes()
    {
        $currentMonth = date('Y-m');
        $cacheKey = "prayer_times_{$currentMonth}";

        // Check if we need to fetch next month data (on last day of month)
        $isLastDayOfMonth = date('d') == date('t');
        $nextMonth = date('Y-m', strtotime('+1 month'));
        $nextMonthCacheKey = "prayer_times_{$nextMonth}";

        // Get current month data
        $currentMonthData = Cache::remember($cacheKey, 24 * 60 * 60, function() use ($currentMonth) {
            return $this->fetchMonthlyPrayerData($currentMonth);
        });

        // Get next month data if on last day of current month
        $nextMonthData = [];
        if ($isLastDayOfMonth) {
            $nextMonthData = Cache::remember($nextMonthCacheKey, 24 * 60 * 60, function() use ($nextMonth) {
                return $this->fetchMonthlyPrayerData($nextMonth);
            });
        }

        // Merge current and next month data
        $allPrayerTimes = array_merge($currentMonthData, $nextMonthData);

        // Update last updated timestamp
        Cache::put('prayer_times_last_updated', time(), 24 * 60 * 60);

        return $allPrayerTimes;
    }

    /**
     * Fetch prayer data for specific month from API
     */
    private function fetchMonthlyPrayerData($yearMonth)
    {
        $prayerTimes = [];
        $year = substr($yearMonth, 0, 4);
        $month = substr($yearMonth, 5, 2);

        // Get number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);

        Log::info("Fetching prayer data for {$yearMonth} ({$daysInMonth} days)");

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dayFormatted = sprintf('%02d', $day);
            $dateKey = "{$year}-{$month}-{$dayFormatted}";

            try {
                // Use Jakarta city code (1301) - you can make this configurable
                $url = "https://api.myquran.com/v2/sholat/jadwal/1301/{$year}/{$month}/{$dayFormatted}";
                $response = Http::timeout(10)->get($url);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['data']['jadwal'])) {
                        $jadwal = $data['data']['jadwal'];

                        $prayerTimes[$dateKey] = [
                            'imsak' => $jadwal['imsak'] ?? '00:00',
                            'subuh' => $jadwal['subuh'] ?? '00:00',
                            'syuruq' => $jadwal['terbit'] ?? '00:00',
                            'dhuha' => $jadwal['dhuha'] ?? '00:00',
                            'dzuhur' => $jadwal['dzuhur'] ?? '00:00',
                            'ashar' => $jadwal['ashar'] ?? '00:00',
                            'maghrib' => $jadwal['maghrib'] ?? '00:00',
                            'isya' => $jadwal['isya'] ?? '00:00',
                        ];
                    }
                } else {
                    Log::warning("Failed to fetch prayer data for {$dateKey}: " . $response->status());
                }

                // Small delay to be respectful to the API
                usleep(100000); // 0.1 second

            } catch (\Exception $e) {
                Log::error("Error fetching prayer data for {$dateKey}: " . $e->getMessage());

                // Use default times if API fails
                $prayerTimes[$dateKey] = [
                    'imsak' => '04:30',
                    'subuh' => '04:40',
                    'syuruq' => '06:00',
                    'dhuha' => '06:30',
                    'dzuhur' => '12:00',
                    'ashar' => '15:00',
                    'maghrib' => '18:00',
                    'isya' => '19:15',
                ];
            }
        }

        Log::info("Successfully fetched prayer data for {$yearMonth}: " . count($prayerTimes) . " days");
        return $prayerTimes;
    }

    /**
     * Get cache version for client-side comparison
     */
    private function getCacheVersion()
    {
        return Cache::get('prayer_cache_version', 1);
    }

    /**
     * Invalidate prayer times cache (for admin use)
     */
    public function invalidateCache()
    {
        $currentMonth = date('Y-m');
        $nextMonth = date('Y-m', strtotime('+1 month'));

        Cache::forget("prayer_times_{$currentMonth}");
        Cache::forget("prayer_times_{$nextMonth}");
        Cache::forget('prayer_times_last_updated');

        // Increment cache version
        $newVersion = Cache::get('prayer_cache_version', 1) + 1;
        Cache::put('prayer_cache_version', $newVersion, 24 * 60 * 60);

        return response()->json([
            'status' => 'success',
            'message' => 'Prayer times cache invalidated',
            'new_version' => $newVersion
        ]);
    }
}
