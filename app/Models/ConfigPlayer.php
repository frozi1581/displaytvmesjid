<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConfigPlayer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mosque_id',
        'background_before_adzan',
        'background_iqama_time',
        'background_prayer_silent',
        'background_lecture',
        'background_transaction',
        'with_imsak',
        'with_syuruq',
        'calculation_method',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
