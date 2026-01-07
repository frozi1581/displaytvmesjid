<?php

namespace App\Http\Controllers\Users\Configs;

use App\Http\Controllers\Controller;
use App\Models\ConfigPlayer;
use App\Models\ConfigPrayer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlayerController extends Controller
{
    public function index()
    {
        $players = [
            'main',
            //'lecture',
            //'transaction',
            'imsak',
            'syuruq',
        ];

        return view('users.configs.players.index', [
            'players' => $players
        ]);
    }

    public function main()
    {
        $user = Auth::user();

        $configPlayer = $user->mosque->configPlayers()->first();
        $configPlayerShow = $user->mosque->configPlayerShows()->first();
        $configPlayerInterval = $user->mosque->configPlayerIntervals()->first();

        return view('users.configs.players.main', [
            'configPlayer' => $configPlayer,
            'configPlayerShow' => $configPlayerShow,
            'configPlayerInterval' => $configPlayerInterval,
        ]);
    }

    public function lecture()
    {
        $user = Auth::user();
        $configPlayer = $user->mosque->configPlayers()->first();
        $configPlayerShow = $user->mosque->configPlayerShows()->first();
        $configPlayerInterval = $user->mosque->configPlayerIntervals()->first();

        $response = Http::get('http://api.aladhan.com/v1/methods');
        $calculationMethods = json_decode(json_encode(Arr::flatten($response->json(), 1)));
        array_splice($calculationMethods, 0, 2);

        unset(
            $calculationMethods[6],
            $calculationMethods[16],
        );

        return view('users.configs.players.lecture', [
            'configPlayer' => $configPlayer,
            'configPlayerShow' => $configPlayerShow,
            'configPlayerInterval' => $configPlayerInterval,
            'calculationMethods' => $calculationMethods,
        ]);
    }

    public function transaction()
    {
        $user = Auth::user();
        $configPlayer = $user->mosque->configPlayers()->first();
        $configPlayerShow = $user->mosque->configPlayerShows()->first();
        $configPlayerInterval = $user->mosque->configPlayerIntervals()->first();

        $response = Http::get('http://api.aladhan.com/v1/methods');
        $calculationMethods = json_decode(json_encode(Arr::flatten($response->json(), 1)));
        array_splice($calculationMethods, 0, 2);
        unset(
            $calculationMethods[6],
            $calculationMethods[16],
        );

        return view('users.configs.players.transaction', [
            'configPlayer' => $configPlayer,
            'configPlayerShow' => $configPlayerShow,
            'configPlayerInterval' => $configPlayerInterval,
            'calculationMethods' => $calculationMethods,
        ]);
    }

    public function imsak()
    {
        $user = Auth::user();
        $configPlayer = $user->mosque->configPlayers()->first();

        $boxBackgroundClasses = [
            'bg-grad-1',
            'bg-grad-2',
            'bg-grad-3',
            'bg-grad-4',
            'bg-grad-5',
            'bg-grad-6',
            'bg-grad-7',
        ];

        $configPrayer = ConfigPrayer::where('name', 'imsak')
            ->where('mosque_id', $user->mosque->id)
            ->first();

        return view('users.configs.players.imsak', [
            'configPrayer' => $configPrayer,
            'boxBackgroundClasses' => $boxBackgroundClasses,
            'configPlayer' => $configPlayer,
        ]);
    }

    public function syuruq()
    {
        $user = Auth::user();
        $configPlayer = $user->mosque->configPlayers()->first();

        $boxBackgroundClasses = [
            'bg-grad-1',
            'bg-grad-2',
            'bg-grad-3',
            'bg-grad-4',
            'bg-grad-5',
            'bg-grad-6',
            'bg-grad-7',
        ];

        $configPrayer = ConfigPrayer::where('name', 'syuruq')
            ->where('mosque_id', $user->mosque->id)
            ->first();

        return view('users.configs.players.syuruq', [
            'configPrayer' => $configPrayer,
            'boxBackgroundClasses' => $boxBackgroundClasses,
            'configPlayer' => $configPlayer,
        ]);
    }

    public function background()
    {
        $user = Auth::user();
        $configPlayer = ConfigPlayer::where('mosque_id', $user->mosque->id)->first();

        $data = [
            (object)[
                'title' => 'Background Saat Adzan',
                'key' => 'background_before_adzan',
                'content' => $configPlayer->background_before_adzan,
            ],
            (object)[
                'title' => 'Background Saat Iqama',
                'key' => 'background_iqama_time',
                'content' => $configPlayer->background_iqama_time,
            ],
            (object)[
                'title' => 'Background Saat Shalat',
                'key' => 'background_prayer_silent',
                'content' => $configPlayer->background_prayer_silent,
            ],
            (object)[
                'title' => 'Background Kajian',
                'key' => 'background_lecture',
                'content' => $configPlayer->background_lecture,
            ],
            (object)[
                'title' => 'Background Transaksi',
                'key' => 'background_transaction',
                'content' => $configPlayer->background_transaction,
            ],
        ];

        return view('users.configs.players.background', [
            'data' => $data
        ]);
    }

    public function upload(Request $request, $key)
    {
        $mosque = Auth::user()->mosque;
        $data = $request->validate([
            $key => 'required|image|mimes:png,jpg,webp',
        ]);

        if ($request->file($key)) {
            $image = $request->file($key);
            $path = $mosque->storage_path . '/config/';
            $filename = $key . '.' . $image->extension();
            $data[$key] = '/storage/' . $path . $filename;
            Storage::disk('public')->putFileAs($path, $image, $filename);
        }

        $mosque->configPlayers()->update($data);

        return redirect()->back();
    }

    public function update(Request $request, $key)
    {
        if ($key === 'main') {

            $data = $request->validate([
                'interval_friday' => 'required|numeric',
                'interval_slider' => 'required|numeric|between:0.10,0.90',
            ]);

            Auth::user()->mosque->configPlayerIntervals()->update($data);
        }

        else if ($key === 'video') {

            $data = $request->validate([
                'show_video' => 'nullable|boolean',
                'interval_video' => 'required_if:show_video,1|numeric',
            ]);

            Auth::user()->mosque->configPlayerShows()->update([
                'show_video' => $data['show_video'] ?? 0,
            ]);

            Auth::user()->mosque->configPlayerIntervals()->update([
                'interval_video' => $data['interval_video'] ?? 0,
            ]);
        }

        else if ($key === 'image') {

            $data = $request->validate([
                'show_image' => 'nullable|boolean',
                'interval_image' => 'required_if:show_image,1|numeric',
            ]);

            Auth::user()->mosque->configPlayerShows()->update([
                'show_image' => $data['show_image'] ?? 0,
            ]);

            Auth::user()->mosque->configPlayerIntervals()->update([
                'interval_image' => $data['interval_image'] ?? 0,
            ]);
        }

        else if ($key === 'calculation_method') {

            $data = $request->validate([
                'calculation_method' => 'required|numeric',
            ]);

            Auth::user()->mosque->configPlayers()->update($data);
        }

        else
            abort(404);

        return redirect()->back();
    }

    public function transactionUpdate(Request $request, $key)
    {
        if ($key === 'show') {

            $data = $request->validate([
                'show_transaction' => 'nullable|boolean',
            ]);

            Auth::user()->mosque->configPlayerShows()->update([
                'show_transaction' => $data['show_transaction'] ?? 0,
            ]);
        }

        else if ($key === 'interval') {

            $data = $request->validate([
                'interval_transaction' => 'required|numeric',
            ]);

            Auth::user()->mosque->configPlayerIntervals()->update([
                'interval_transaction' => $data['interval_transaction'] ?? 0,
            ]);
        }

        else if ($key === 'background') {

            $mosque = Auth::user()->mosque;
            $data = $request->validate([
                'background_transaction' => 'required|image|mimes:png,jpg,webp',
            ]);

            if ($request->file('background_transaction')) {
                $image = $request->file('background_transaction');
                $path = $mosque->storage_path . '/config/';
                $filename = 'background_transaction.' . $image->extension();
                $data['background_transaction'] = '/storage/' . $path . $filename;
                Storage::disk('public')->putFileAs($path, $image, $filename);
            }

            $mosque->configPlayers()->update($data);
        }

        else
            abort(404);

        return redirect()->back();
    }

    public function lectureUpdate(Request $request, $key)
    {
        if ($key === 'show') {

            $data = $request->validate([
                'show_lecture' => 'nullable|boolean',
            ]);

            Auth::user()->mosque->configPlayerShows()->update([
                'show_lecture' => $data['show_lecture'] ?? 0,
            ]);
        }

        else if ($key === 'interval') {

            $data = $request->validate([
                'interval_lecture' => 'required|numeric',
            ]);

            Auth::user()->mosque->configPlayerIntervals()->update([
                'interval_lecture' => $data['interval_lecture'] ?? 0,
            ]);
        }

        else if ($key === 'background') {

            $mosque = Auth::user()->mosque;
            $data = $request->validate([
                'background_lecture' => 'required|image|mimes:png,jpg,webp',
            ]);

            if ($request->file('background_lecture')) {
                $image = $request->file('background_lecture');
                $path = $mosque->storage_path . '/config/';
                $filename = 'background_lecture.' . $image->extension();
                $data['background_lecture'] = '/storage/' . $path . $filename;
                Storage::disk('public')->putFileAs($path, $image, $filename);
            }

            $mosque->configPlayers()->update($data);
        }

        else
            abort(404);

        return redirect()->back();
    }

    public function imsakUpdate(Request $request, $key)
    {
        if ($key === 'show')
            Auth::user()->mosque->configPlayers()->update([
                'with_imsak' => $request['with_imsak'] ?? 0,
            ]);

        else if ($key === 'prayer') {

            $data = $request->validate([
                'time_adjustment' => 'required|numeric',
                'box_background_class' => 'required|string',
            ]);

            Auth::user()->mosque->configPrayers()->where('name', 'imsak')->update($data);
        }

        else
            abort(404);

        return redirect()->back();
    }

    public function syuruqUpdate(Request $request, $key)
    {
        if ($key === 'show')
            Auth::user()->mosque->configPlayers()->update([
                'with_syuruq' => $request['with_syuruq'] ?? 0,
            ]);

        else if ($key === 'prayer') {

            $data = $request->validate([
                'time_adjustment' => 'required|numeric',
                'box_background_class' => 'required|string',
            ]);

            Auth::user()->mosque->configPrayers()->where('name', 'syuruq')->update($data);
        }

        else
            abort(404);

        return redirect()->back();
    }
}
