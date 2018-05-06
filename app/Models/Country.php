<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string|null $iso
 * @property string|null $name
 * @property string|null $nicename
 * @property string|null $iso3
 * @property int|null $numcode
 * @property int|null $phonecode
 * @property int|null $zipcode
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereNicename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereNumcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country wherePhonecode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereZipcode($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    //
}
