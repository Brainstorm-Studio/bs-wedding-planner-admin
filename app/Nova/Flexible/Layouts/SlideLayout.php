<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\Facades\Storage;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Laravel\Nova\Fields\BooleanGroup;
use Spatie\MediaLibrary\HasMedia;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SlideLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;
    protected $name = 'slide';
    protected $title = 'Slide';

    public function fields()
    {
        return [
            // Text::make('Title', 'title')
            //     ->required(),
            // Text::make('Sub Title', 'sub_title'),
            // Textarea::make('Copy', 'copy')
            //     ->rules('max:255')
            //     ->maxlength('255'),
            Image::make('Image', 'image')
                ->disk('spaces')
                ->storeOriginalName('attachment_name')
                ->disableDownload()
                ->preview(function ($value, $disk) {
                    return $value
                        ? Storage::disk($disk)->url($value)
                        : null;
                })
                ->acceptedTypes(['.webp', '.jpg', '.jpeg'])
                ->rules(
                    'mimes:webp,jpg,jpeg',
                    'dimensions:min_width=600,min_height=600',
                    'max:750'
                )
                ->help('Minimum dimensions: 600x600, optimal dimensions: 1920X1080. format: webp, jpg, jpeg, Max size: 750kb'),
            // Text::make('Button Text', 'button_text')
            //     ->hideFromIndex(),
            // URL::make('URL', 'url')
            //     ->hideFromIndex(),
            // BooleanGroup::make('Options')->options([
            //     'new_window' => 'Open in new window',
            //     'active' => 'Active Slide',
            //     'show_button' => 'Show Button',
            // ]),
        ];
    }
}
