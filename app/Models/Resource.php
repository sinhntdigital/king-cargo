<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {
    protected $table = 'resources';
    protected $fillable = ['id', 'type', 'full_name'];
    protected $hidden = [];
    public $timestamps = true;
    public $incrementing = false;
}
