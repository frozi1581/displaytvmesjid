<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prayerdata extends Model
{
    use HasFactory;

    public $table = "prayerdata";

    protected $fillable = [
        'idprayer',
        'wilayah',
        'tgl',
        'subuh',
        'syuruq',
        'dhuha',
        'dzuhur',
        'ashar',
        'maghrib',
        'isya'
    ];


}
