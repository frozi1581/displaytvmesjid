<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $prayers = [
            'subuh',
            'dzuhur',
            'ashar',
            'maghrib',
            'isya',
        ];

        $players = [
            'main',
            //'lecture',
            //'transaction',
            'imsak',
            'syuruq',
        ];

        return view('users.configs.index', [
            'prayers' => $prayers,
            'players' => $players,
        ]);
    }
}
