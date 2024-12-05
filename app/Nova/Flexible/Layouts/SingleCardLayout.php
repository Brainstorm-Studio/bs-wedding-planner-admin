<?php

namespace App\Nova\Flexible\Layouts;


use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Mostafaznv\NovaCkEditor\CkEditor;
use Illuminate\Support\Facades\Storage;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SingleCardLayout extends Layout
{
    protected $name = 'card';
    protected $title = 'Tarjeta';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'min:0', 'max:100'),
            CkEditor::make('Text', 'text')
                ->toolbar('toolbar-2')
                ->stacked()
                ->fullWidth()
                ->hideFromIndex()
                ->rules('required')
            ,
            // Select::make('Formato', 'format')
            //     ->options([
            //         'left_text' => 'Caja de texto a la izquieda',
            //         'right_text' => 'Caja de texto a la derecha',
            //     ])
            //     ->rules('required'),
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
                    'dimensions:min_width=600,min_height=600'
                )
                ->help('<strong>Minimum dimensions: 600x600, format: webp, jpg, jpeg, Max size: 750kb</strong>'),
            Boolean::make('Contact form', 'show_contact_card')
                ->help('If checked Contact form, a contact form will be displayed in the card and the button will be hidden'),
            Text::make('Button Text', 'button_text'),
            Text::make('Button URL', 'button_url')
        ];
    }
}
