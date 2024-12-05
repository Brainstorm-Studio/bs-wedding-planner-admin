<?php

namespace App\Nova\Flexible\Layouts;


use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Mostafaznv\NovaCkEditor\CkEditor;
use Illuminate\Support\Facades\Storage;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class AccordionLayout extends Layout
{
    protected $name = 'accordion';
    protected $title = 'Accordion';

    public function fields()
    {
        return [
            Text::make('Accordion Title', 'title')
                ->rules('required', 'min:0', 'max:225'),
            Flexible::make('Accordion', 'accordion')
                ->fullWidth()
                ->button('Add Accordion Item')
                ->addLayout('Accordion Item', 'accordion_item', [
                    Text::make('Accordion Title', 'accordion_title')
                        ->rules('required', 'min:0', 'max:225'),
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
                            'dimensions:min_width=600,min_height=6000',
                            'max:750'
                        )
                        ->help('Minimum dimensions: 600x600, format: webp, jpg, jpeg, Max size: 750kb'),
                ])->collapsed()->confirmRemove()
        ];
    }
}
