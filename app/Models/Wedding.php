<?php

namespace App\Models;

use App\Traits\Slugable;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Wedding extends Model implements HasMedia
{
    protected $table = 'weddings';

    use SoftDeletes,
        InteractsWithMedia,
        Slugable;
    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'content' => 'array',
        'couple_name' => 'array',
        'features' => 'array',
        'date' => 'array',
        'location' => 'array',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);

        $this->addMediaConversion('main_op')
            ->optimize()
            ->quality(70);

        $this->addMediaConversion('gallery_op')
            ->optimize()
            ->quality(70);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('main_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->registerMediaConversions(function (Media $media = null) {
                $this->addMediaConversion('main_op')
                    ->format('webp')
                    ->optimize()
                    ->quality(70);
                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->registerMediaConversions(function (Media $media = null) {
                $this->addMediaConversion('gallery_op')
                    ->format('webp')
                    ->optimize()
                    ->quality(70);
                $this->addMediaConversion('thumb')
                    ->width(100)
                    ->height(100);
            });
    }
    public function getMainImageAttribute()
    {
        return $this->getFirstMediaUrl('main_image', 'main_op');
    }

    public function getGalleryAttribute()
    {
        return $this->getMedia('gallery');
    }

}
