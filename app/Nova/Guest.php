<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use App\Nova\Actions\SendWhatsapp;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Http\Requests\NovaRequest;

class Guest extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Guest>
     */
    public static $model = \App\Models\Guest::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'guest_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'guest_name',
        'wedding.name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()
                ->hideFromIndex(),
            BelongsTo::make('Country', 'country', Country::class)
                ->withoutTrashed(),
            BelongsTo::make('Guest Type', 'guest_type', GuestType::class)
                ->withoutTrashed(),
            BelongsTo::make('Wedding', 'wedding', Wedding::class)
                ->withoutTrashed(),
            Text::make('Guest Name', 'guest_name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Couple Name', 'couple_name')
                ->rules('max:255'),
            Email::make('Email', 'email')
                ->sortable()
                ->hideFromIndex(),
            Text::make('Phone', 'phone')
                ->hideFromIndex()
                ->sortable()
                ->rules('required', 'max:255'),
            Boolean::make('RSVP', 'rsvp')
                ->sortable()
                ->rules('required'),
            Boolean::make('With Plus One', 'with_plus_one')
                ->sortable()
                ->default(false),
            Number::make('Total invited', 'plus_one_count')
                ->sortable()
                ->default(0),
            Number::make('Total Confirmed', 'total_confirmed'),
            Boolean::make('Allergies', 'has_allergies')
                ->sortable()
                ->default(false),
            Trix::make('Allergies Details', 'allergies')
                ->rules('max:255')
                ->hideFromIndex(),
            Trix::make('Note', 'note')
                ->rules('max:255')
                ->hideFromIndex(),
            DateTime::make('RSVP Date', 'rsvp_date')
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new SendWhatsapp)
            ->confirmText('Estimad@ '. $this->guest_name . ' ' .$this->couple_name . ' , tenemos el honor de invitarlos a nuestra boda. Por favor confirma tu asistencia en el siguiente enlace: https://www.nuestraboda-esteban-y-fernanda.com/')
            ->confirmButtonText('Enviar Whatsapp')
            ->cancelButtonText('Cancelar')
            ->onlyInline(),
        ];
    }
}
