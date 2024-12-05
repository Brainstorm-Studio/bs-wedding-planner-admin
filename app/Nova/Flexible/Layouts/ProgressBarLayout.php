<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ProgressBarLayout extends Layout
{
    protected $name = 'progress-bar';
    protected $title = 'Progress Bar';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'min:0', 'max:100'),
            Flexible::make('Progress Bar', 'progress')
                ->button('Add Progress Bar')
                ->fullWidth()
                ->addLayout('Item', 'item', [
                    Text::make('Title', 'title')
                        ->rules('required', 'min:0', 'max:100'),
                    Number::make('Percentage', 'percentage')
                        ->rules('required', 'min:0', 'max:100')
                ])->collapsed()->confirmRemove()
        ];
    }
}
