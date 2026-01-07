<?php

namespace App\Http\Controllers\Users\Configs;

use App\Http\Controllers\Controller;
use App\Models\ConfigPrayer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PrayerController extends Controller
{
    public function index()
    {
        $prayers = [
            'subuh',
            'dzuhur',
            'ashar',
            'maghrib',
            'isya',
        ];

        return view('users.configs.prayers.index', [
            'prayers' => $prayers
        ]);
    }

    public function edit($prayer)
    {
        $boxBackgroundClasses = [
            'bg-grad-1',
            'bg-grad-2',
            'bg-grad-3',
            'bg-grad-4',
            'bg-grad-5',
            'bg-grad-6',
            'bg-grad-7',
        ];

        $configPrayer = ConfigPrayer::where('name', $prayer)
            ->where('mosque_id', Auth::user()->mosque->id)
            ->first();

        return view('users.configs.prayers.edit', [
            'configPrayer' => $configPrayer,
            'boxBackgroundClasses' => $boxBackgroundClasses,
        ]);
    }

    public function update(Request $request, ConfigPrayer $configPrayer)
    {
        $data = $request->validate([
            'time_adjustment' => 'required|numeric',
            'before_adzan_interval' => 'required|numeric',
            'iqama_interval' => 'required|numeric',
            'prayer_interval' => 'required|numeric',
            'box_background_class' => 'required|string',
        ]);

        $configPrayer->update($data);


        //Update agar aplikasi android melakukan refresh dengan flag is_refresh=true
        $mosque = Auth::user()->mosque;
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://masjid.layanan-aplikasi.com/public/refresh-status?player_token=".$mosque->player_token."&vIsRefresh=true",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "authorization: Bearer your-access-token",
                "content-type: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return redirect()->back();
    }
}
