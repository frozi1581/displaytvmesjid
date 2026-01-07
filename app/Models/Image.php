<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $appends = [
        'url',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mosque_id',
        'path',
        'name',
        'start_date',
        'end_date',
        'status'
    ];

    protected function getUrlAttribute()
    {
        return Storage::url($this->path . $this->name);
    }

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
