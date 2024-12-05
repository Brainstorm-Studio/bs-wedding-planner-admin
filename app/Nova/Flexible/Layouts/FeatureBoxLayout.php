<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use AlexAzartsev\Heroicon\Heroicon;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FeatureBoxLayout extends Layout
{
    protected $name = 'feature-box';
    protected $title = 'Feature Box';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'max:100'),
            Flexible::make('Feature box', 'feature_box')
                ->button('Add Item')
                ->fullWidth()
                ->addLayout('Feature box', 'feature_box', [
                    Text::make('Title', 'text')
                        ->rules('required', 'max:100'),
                    Textarea::make('Copy', 'copy')
                        ->maxlength(200)
                        ->rules('max:200'),
                    Heroicon::make('Icon', 'icon')
                ])->confirmRemove()
        ];
    }
}
