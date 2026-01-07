<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class File extends Model
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
        'type',
        'is_template',
        'path',
        'name',
        'mimetype',
        'status',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_template' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the URL attribute for the file
     */
    protected function getUrlAttribute()
    {
        return Storage::url($this->path . $this->name);
    }

    /**
     * Get the full file path
     */
    public function getFullPathAttribute()
    {
        return $this->path . $this->name;
    }

    /**
     * Get the file size
     */
    public function getSizeAttribute()
    {
        if (Storage::disk('public')->exists($this->full_path)) {
            return Storage::disk('public')->size($this->full_path);
        }
        return 0;
    }

    /**
     * Get human readable file size
     */
    public function getHumanSizeAttribute()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is currently active
     */
    public function getIsActiveAttribute()
    {
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date > $now && $this->status == '1';
    }

    /**
     * Check if file is scheduled
     */
    public function getIsScheduledAttribute()
    {
        return $this->start_date > Carbon::now() && $this->status == '2';
    }

    /**
     * Check if file is expired
     */
    public function getIsExpiredAttribute()
    {
        return $this->end_date <= Carbon::now() && $this->status == '0';
    }

    /**
     * Check if file is archived
     */
    public function getIsArchivedAttribute()
    {
        return $this->status === 'archived';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case '1':
                return 'Aktif';
            case '2':
                return 'Terjadwal';
            case '0':
                return 'Kadaluarsa';
            case 'archived':
                return 'Diarsipkan';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get status color class
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case '1':
                return 'success';
            case '2':
                return 'warning';
            case '0':
                return 'danger';
            case 'archived':
                return 'secondary';
            default:
                return 'secondary';
        }
    }

    /**
     * Relationship with Mosque
     */
    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    /**
     * Scope for active files
     */
    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    /**
     * Scope for scheduled files
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', '2');
    }

    /**
     * Scope for expired files
     */
    public function scopeExpired($query)
    {
        return $query->where('status', '0');
    }

    /**
     * Scope for archived files
     */
    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    /**
     * Scope for non-archived files
     */
    public function scopeNotArchived($query)
    {
        return $query->where('status', '!=', 'archived');
    }

    /**
     * Scope by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Delete physical file when model is deleted
        static::deleting(function ($file) {
            if (Storage::disk('public')->exists($file->full_path)) {
                Storage::disk('public')->delete($file->full_path);
            }
        });
    }
}
