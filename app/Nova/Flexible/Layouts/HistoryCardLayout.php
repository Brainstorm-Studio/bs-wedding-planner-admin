<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Mostafaznv\NovaCkEditor\CkEditor;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class HistoryCardLayout extends Layout
{
    protected $name = 'history-text-layout';
    protected $title = 'History';

    protected $limit = 1;
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
