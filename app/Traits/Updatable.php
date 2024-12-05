<?php
namespace App\Traits;

use App\Models\User;

trait Updatable
{
    /**
     * Get the updater of the plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
