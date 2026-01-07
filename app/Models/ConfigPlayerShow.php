<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPlayerShow extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mosque_id',
        'show_main',
        'show_transaction',
        'show_lecture',
        'show_video',
        'show_image',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
