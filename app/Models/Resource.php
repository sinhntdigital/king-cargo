<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    
    /**
 * App\Models\Resource
 *
 * @property string                        $id
 * @property string                        $type
 * @property string|null                   $full_name
 * @property string|null                   $representative
 * @property string|null                   $birthday
 * @property string|null                   $address
 * @property string|null                   $country_id
 * @property string|null                   $phone_number
 * @property string                        $status
 * @property string|null                   $creator_id
 * @property \Carbon\Carbon|null           $created_at
 * @property \Carbon\Carbon|null           $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\User|null    $creator
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereRepresentative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $email
 * @property string|null $identify
 * @property string $class
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Resource whereIdentify($value)
 */
    class Resource extends Model {
        
        // Define table name
        protected $table    = 'resources';
        
        // Define fillable columns
        protected $fillable = [
            'id',
            'full_name',
            'representative',
            'birthday',
            'address',
            'country_id',
            'phone_number',
            'email',
            'identify',
            'class',
            'type',
            'status',
            'creator_id',
        ];
        
        // Define hidden columns
        protected $hidden = [
            'country_id',
            'creator_id',
        ];
        
        // Enable / Disable timestamps
        public $timestamps = true;
        
        // Enable / Disable auto incrementing on ID columns
        public $incrementing = false;
        
        /**
         * get creator
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function creator() {
            return $this->belongsTo(User::class);
        }
        
        /**
         * Get country
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function country() {
            return $this->belongsTo(Country::class);
        }
        
    }
