<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Package
 *
 * @property int $id
 * @property string $info
 * @property string $package_code
 * @property string|null $type
 * @property string $shipper_id
 * @property string $ship_date
 * @property string $recipient_id
 * @property string $recipient_date
 * @property float $declared_value
 * @property float $shipping_price
 * @property float $insurance
 * @property float $total_price
 * @property string $creator_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereDeclaredValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package wherePackageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereRecipientDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShipDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShipperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereShippingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Package whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Package extends Model
{
    //
}
