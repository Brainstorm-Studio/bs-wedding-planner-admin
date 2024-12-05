<?php

namespace App\Nova\Flexible\Layouts;


use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Mostafaznv\NovaCkEditor\CkEditor;
use Illuminate\Support\Facades\Storage;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TabsLayout extends Layout
{
    protected $name = 'tabs';
    protected $title = 'Tabs';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'min:0', 'max:100'),
            Flexible::make('Tab', 'tab')
                ->fullWidth()
                ->button('Add Tab')
                ->required()
                ->addLayout('Tab', 'tab', [
                    Text::make('Tab Title', 'tab_title')
                        ->rules('required', 'min:0', 'max:225')
                        ->help('Max 255 characters'),
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
                        ->help('Minimum dimensions: 600, format: webp, jpg, jpeg, Max size: 750kb'),
                ])->collapsed()->confirmRemove()
        ];
    }
}
