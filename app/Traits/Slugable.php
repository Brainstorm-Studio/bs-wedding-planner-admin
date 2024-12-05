<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait Slugable
{
    /**
     * Set the slug attribute.
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function setNameEnAttribute($value)
    {
        $this->attributes['name_en'] = $value;
        $this->attributes['slug_en'] = Str::slug($value);
    }

}
