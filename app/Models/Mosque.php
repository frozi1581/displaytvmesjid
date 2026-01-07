<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Mosque extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'player_token',
        'logo_url',
        'name',
        'email',
        'phone',
        'manager',
        'address',
        'city',
        'province',
        'postal_code',
        'storage_path',
        'marketing_campaign',
        'hide_phone',
        'is_refresh'
    ];

    protected $appends = [
        'faddress',
    ];

    protected $hidden = [
        'storage_path',
    ];

    protected function getLogoAttribute() : string
    {
        if (Str::match('/http/', $this->logo_url))
            return $this->logo_url;

        return Storage::url($this->storage_path . '/logo/' . $this->logo_url);
    }

    protected function getFaddressAttribute() : string
    {
        $faddress  = $this->address;
        $faddress .= $this->city ? ', '. $this->city : '';
        $faddress .= $this->province ? ', '. $this->province : '';
        $faddress .= $this->zip ? ' - '. $this->zip : '';

        return $faddress;
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function configPlayers() : HasMany
    {
        return $this->hasMany(ConfigPlayer::class);
    }

    public function configPrayers() : HasMany
    {
        return $this->hasMany(ConfigPrayer::class);
    }

    public function configPlayerIntervals() : HasMany
    {
        return $this->hasMany(ConfigPlayerInterval::class);
    }

    public function configPlayerShows() : HasMany
    {
        return $this->hasMany(ConfigPlayerShow::class);
    }

    public function files() : HasMany
    {
        return $this->hasMany(File::class);
    }

    public function lectures() : HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    public function marquees() : HasMany
    {
        return $this->hasMany(Marquee::class);
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
