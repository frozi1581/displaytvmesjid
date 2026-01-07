<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use ArPHP\I18N\Arabic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use stdClass;
use Carbon\Carbon;

class PlayerController extends Controller
{
    public function index($token)
    {
        $date = new stdClass();
        $mosque = Mosque::wherePlayerToken($token)->first();
        $configPlayer = $mosque->configPlayers()->first();
        $configPlayerShow = $mosque->configPlayerShows()->first();
        $configPlayerInterval = $mosque->configPlayerIntervals()->first();
        //dd($configPlayerInterval);

        // Tanggal saat ini
        $tglMulaiImage = Carbon::now();
        $tglSelesaiImage = $tglMulaiImage->addDay();

        if($tglMulaiImage<=Carbon::create('2024-03-10 21:00:00')){
            $tglSelesaiImageStr = '2024-03-10 21:00:00';
            $tglMulaiImageStr = '2024-03-07 21:01:00';
        }else{
            $tglSelesaiImageStr = $tglMulaiImage->format('Y-m-d')." 21:00:00";
            $tglMulaiImageStr = $tglMulaiImage->format('Y-m-d')." 21:01:00";
        }


        $prayers = $mosque->configPrayers()->where('is_prayer_time', 1);
        //$images = $mosque->files()->where('type','like', 'image')
        //    ->where('start_date','>=',$tglMulaiImageStr)
        //    ->where('end_date','<=',$tglSelesaiImageStr)
        //    ->get();

        $images = $mosque->files()->where('type','like', 'image')
            ->get();

        $marquees = $mosque->marquees;
        $backgrounds = $mosque->files()->where('type', 'background')->first();
        //dd($images);

        $arabic = new Arabic();
        $now = time();
        $correction = $arabic->dateCorrection($now);
        //$date->day = $arabic->date('l', $now, $correction) . ' | ' . date('l');
        $date->day = date('l');
        /*switch($date->day){
            case "Monday":
                $date->day = "Senin";
                break;
            case "Tuesday":
                $date->day = "Selasa";
                break;
            case "Wednesday":
                $date->day = "Rabu";
                break;
            case "Thursday":
                $date->day = "Kamis";
                break;
            case "Friday":
                $date->day = "Jum'at";
                break;
            case "Saturday":
                $date->day = "Sabtu";
                break;
            case "Sunday":
                $date->day = "Minggu";
                break;

            default:
                break;
        }*/

        $date->georgian = date('d F Y');
        $date->hijri = $arabic->date('Y j, F', $now, $correction);

        if ($configPlayer->with_imsak)
            $prayers->orWhere(function($q) use ($mosque) {
                $q->where('mosque_id', $mosque->id)
                    ->where('name', 'imsak');
            });

        if ($configPlayer->with_syuruq)
            $prayers->orWhere(function($q) use ($mosque) {
                $q->where('mosque_id', $mosque->id)
                    ->where('name', 'syuruq');
            });

        $prayers = $prayers->orderBy('order')->get();
        $response = Http::get('https://api.myquran.com/v2/sholat/jadwal/1301/' . date('Y/m/d'));
        if ($response->ok()) {
            $data = json_decode($response->body())->data;
            $data->jadwal->syuruq = $data->jadwal->terbit;
            unset(
                $data->jadwal->tanggal,
                $data->jadwal->date,
                $data->jadwal->dhuha,
                $data->jadwal->terbit);
            $prayerData = (array)$data->jadwal;
        } else {
            echo $response->body();
            abort(500, 'Sorry, There is error in external API.');
        }

        foreach ($prayers as $prayer) {
            $prayers->time = '00:00';
            if ($prayer->name)
                $prayer->time = date('H:i', strtotime($prayerData[$prayer->name]) + ($prayer->time_adjustment * 60));
        }
        //dd($images);

        return view('users.players.index', [
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
        ]);
    }
}
