<?php

namespace App\Models;

use App\Models\Guest;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestType extends Model
{
    protected $table = 'guest_types';

    use SoftDeletes,
        Slugable;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }
}
