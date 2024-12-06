<?php

namespace App\Models;

use App\Models\GuestType;
use App\Models\WeddingAssignment;
use Illuminate\Database\Eloquent\Model;


class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'couple_name',
        'phone',
        'rsvp',
        'with_plus_one',
        'allergies',
        'rsvp_date',
        'notes'
    ];

    public function guest_type()
    {
        return $this->belongsTo(GuestType::class);
    }

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    public function wedding_assignments()
    {
        return $this->hasMany(WeddingAssignment::class);
    }
}
