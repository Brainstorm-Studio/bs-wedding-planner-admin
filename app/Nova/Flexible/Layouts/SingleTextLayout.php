<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Mostafaznv\NovaCkEditor\CkEditor;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SingleTextLayout extends Layout
{
    protected $name = 'single-text-layout';
    protected $title = 'Solo texto';

    public function fields()
    {
        return [
            Text::make('Title', 'title'),
            CkEditor::make('Text', 'text')
                ->toolbar('toolbar-2')
                ->stacked()
                ->fullWidth()
                ->hideFromIndex()
                ->rules('required')
            ,
        ];
    }
}
