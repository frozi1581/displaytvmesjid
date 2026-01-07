<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPlayerInterval extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mosque_id',
        'interval_friday',
        'interval_lecture',
        'interval_transaction',
        'interval_image',
        'interval_video',
        'interval_slider',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
