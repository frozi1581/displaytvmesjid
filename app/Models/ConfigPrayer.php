<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPrayer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mosque_id',
        'name',
        'key',
        'is_prayer_time',
        'order',
        'box_background_class',
        'before_adzan_interval',
        'iqama_interval',
        'prayer_interval',
        'time_adjustment',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
