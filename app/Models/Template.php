<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Template extends Model
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
        'file_type',
        'is_marketing_campaign',
        'path',
        'name',
    ];

    protected function getUrlAttribute()
    {
        return Storage::url($this->path . $this->name);
    }
}
