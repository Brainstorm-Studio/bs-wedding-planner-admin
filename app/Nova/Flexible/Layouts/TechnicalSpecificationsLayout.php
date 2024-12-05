<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class TechnicalSpecificationsLayout extends Layout
{
    protected $name = 'technical-specifications';
    protected $title = 'Technical Specifications';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'max:100'),
            Flexible::make('Technical Specifications', 'technical_specifications')
                ->button('Add Specification')
                ->fullWidth()
                ->addLayout('Specification', 'specification', [
                    Text::make('Title', 'title')
                        ->rules('required', 'max:100'),
                    Text::make('Value', 'value')
                        ->rules('required', 'max:100')
                ])->collapsed()->confirmRemove()
        ];
    }
}
