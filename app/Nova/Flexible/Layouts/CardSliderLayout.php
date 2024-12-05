<?php

namespace App\Nova\Flexible\Layouts;


use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Mostafaznv\NovaCkEditor\CkEditor;
use Illuminate\Support\Facades\Storage;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class CardSliderLayout extends Layout
{
    protected $name = 'card_slider';
    protected $title = 'Slider';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'min:0', 'max:100'),
            Flexible::make('Card Slider', 'card_slider')
                ->fullWidth()
                ->button('Add Card')
                ->addLayout('card_slide', 'card_slide', [
                    Text::make('Title', 'title')
                        ->rules('required', 'min:0', 'max:100'),
                    CkEditor::make('Text', 'text')
                        ->toolbar('toolbar-2')
                        ->stacked()
                        ->fullWidth()
                        ->hideFromIndex()
                        ->rules('required')
                    ,
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
                        ->help('Minimum dimensions: 600x600, format: webp, jpg, jpeg, Max size: 750kb'),
                    Boolean::make('Contact form', 'show_contact_card')
                        ->help('If checked Contact form, a contact form will be displayed in the card and the button will be hidden'),
                    Text::make('Button Text', 'button_text')
                        ->canSee(function ($request) {
                            return !$this->show_contact;
                        }),
                    Text::make('Button URL', 'button_url')
                        ->canSee(function ($request) {
                            return !$this->show_contact;
                        }),
                ])->confirmRemove()->collapsed(),
        ];
    }
}
