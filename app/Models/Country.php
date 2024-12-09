<?php

namespace App\Models;

use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    use Slugable;

    protected $fillable = [
        'name',
        'code',
        'slug',
        'phone_code',
    ];

}
