<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class VideoLayout extends Layout
{
    protected $name = 'video';
    protected $title = 'Video';

    public function fields()
    {
        return [
            Text::make('Title', 'title')
                ->rules('required', 'min:0'),
            Textarea::make('Copy', 'copy')
                ->maxlength(200)
                ->rules('required', 'max:200'),
            Text::make('Youtube video ID', 'video_id')
                ->help('El código del video se encuentra al final del url de youtube por ejemplo:<br>
        Si el url del video es: https://www.youtube.com/watch?v=mkggXE5e2yk el código a utilizar es todo lo que se encuentra a partir del <strong> v=</strong><br>
        en este caso el código es: <strong>mkggXE5e2yk</strong> ')
                ->rules('required', 'min:3'),
        ];
    }
}
