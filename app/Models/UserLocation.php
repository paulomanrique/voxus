<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    use HasFactory;

    protected $table = 'user_locations';

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    protected $fillable = ['user_id'];
}
