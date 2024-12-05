<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Mostafaznv\NovaCkEditor\CkEditor;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class WeddingCopiesLayout extends Layout
{
    protected $name = 'wedding-copies-layout';
    protected $title = 'Copies';

    // protected $limit = 1;
    public function fields()
    {
        return [
            Flexible::make('Copies', 'copies')
                ->addLayout('Type', 'type', [
                    Select::make('Type', 'type')
                    ->options([
                        'welcome' => 'Welcome',
                        'ceremony' => 'Ceremony',
                        'dress-him' => 'Dress Code For  Him',
                        'dress-her' => 'Dress Code for Her',
                        'advise' => 'Children Advise',
                        'gifts' => 'Gifts',
                        'rsvp' => 'RSVP',
                    ]),
                Textarea::make('text', 'text')
                    ->required(),
            ])->button('Agregar copy')
            ->collapsed()
            ->confirmRemove()
            ->required()
        ];
    }
}
