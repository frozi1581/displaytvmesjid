<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mosque_id',
        'topic',
        'description',
        'speaker',
        'time',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
