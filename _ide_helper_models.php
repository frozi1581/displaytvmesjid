<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ConfigPlayer
 *
 * @property int $id
 * @property int $mosque_id
 * @property string|null $background_before_adzan
 * @property string|null $background_iqama_time
 * @property string|null $background_prayer_silent
 * @property string|null $background_lecture
 * @property string|null $background_transaction
 * @property int $with_imsak
 * @property int $with_syuruq
 * @property string|null $calculation_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereBackgroundBeforeAdzan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereBackgroundIqamaTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereBackgroundLecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereBackgroundPrayerSilent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereBackgroundTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereCalculationMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereWithImsak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayer whereWithSyuruq($value)
 */
	class ConfigPlayer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConfigPlayerInterval
 *
 * @property int $id
 * @property int $mosque_id
 * @property float $interval_friday
 * @property float $interval_lecture
 * @property float $interval_transaction
 * @property float $interval_image
 * @property float $interval_video
 * @property float $interval_slider
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereIntervalFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereIntervalImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereIntervalLecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereIntervalSlider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereIntervalTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereIntervalVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerInterval whereUpdatedAt($value)
 */
	class ConfigPlayerInterval extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConfigPlayerShow
 *
 * @property int $id
 * @property int $mosque_id
 * @property int $show_main
 * @property int $show_transaction
 * @property int $show_lecture
 * @property int $show_video
 * @property int $show_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereShowImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereShowLecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereShowMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereShowTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereShowVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPlayerShow whereUpdatedAt($value)
 */
	class ConfigPlayerShow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConfigPrayer
 *
 * @property int $id
 * @property int $mosque_id
 * @property string $name
 * @property string|null $key
 * @property string $box_background_class
 * @property int $is_prayer_time
 * @property int $time_adjustment
 * @property int $before_adzan_interval
 * @property int $iqama_interval
 * @property int $prayer_interval
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereBeforeAdzanInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereBoxBackgroundClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereIqamaInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereIsPrayerTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer wherePrayerInterval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereTimeAdjustment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPrayer whereUpdatedAt($value)
 */
	class ConfigPrayer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\File
 *
 * @property int $id
 * @property int $mosque_id
 * @property int $is_template
 * @property string $type
 * @property string $path
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereIsTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 */
	class File extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Lecture
 *
 * @property int $id
 * @property int $mosque_id
 * @property string $topic
 * @property string $description
 * @property string $speaker
 * @property string $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereSpeaker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereTopic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lecture whereUpdatedAt($value)
 */
	class Lecture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Marquee
 *
 * @property int $id
 * @property int $mosque_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Marquee whereUpdatedAt($value)
 */
	class Marquee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Mosque
 *
 * @property int $id
 * @property int $user_id
 * @property string $player_token
 * @property string|null $logo_url
 * @property string $name
 * @property string|null $email
 * @property int|null $phone
 * @property string|null $manager
 * @property string|null $address
 * @property string|null $city
 * @property string|null $province
 * @property string|null $postal_code
 * @property string|null $storage_path
 * @property int $marketing_campaign
 * @property int $hide_phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigPlayerInterval[] $configPlayerIntervals
 * @property-read int|null $config_player_intervals_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigPlayerShow[] $configPlayerShows
 * @property-read int|null $config_player_shows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigPlayer[] $configPlayers
 * @property-read int|null $config_players_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigPrayer[] $configPrayers
 * @property-read int|null $config_prayers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lecture[] $lectures
 * @property-read int|null $lectures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Marquee[] $marquees
 * @property-read int|null $marquees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereHidePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereMarketingCampaign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque wherePlayerToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereStoragePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mosque whereUserId($value)
 */
	class Mosque extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrayerBoxBackground
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrayerBoxBackground whereUpdatedAt($value)
 */
	class PrayerBoxBackground extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Template
 *
 * @property int $id
 * @property string $type
 * @property int $is_marketing_campaign
 * @property string $path
 * @property string $name
 * @property string $thumbnail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Template newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Template newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Template query()
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereIsMarketingCampaign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereUpdatedAt($value)
 */
	class Template extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $mosque_id
 * @property int $amount
 * @property string $direction
 * @property string $exchange
 * @property string $description
 * @property string $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque $mosque
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereExchange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMosqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mosque|null $mosque
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

