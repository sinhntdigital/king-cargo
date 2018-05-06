<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LoginHistory
 *
 * @property int $id
 * @property string $user_id
 * @property string|null $ip
 * @property string|null $device
 * @property string|null $browser
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LoginHistory whereUserId($value)
 * @mixin \Eloquent
 */
class LoginHistory extends Model
{
    //
}
