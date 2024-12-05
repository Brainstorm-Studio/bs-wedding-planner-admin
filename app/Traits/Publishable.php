<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait Publishable
{
    /**
     * Get the publisher of the plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Set the published attribute
     *
     * @param $value
     */
    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = $value;
    }
}
