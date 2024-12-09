<?php

namespace App\Nova;


use Carbon\Carbon;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Url;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Flexible\Layouts\TabsLayout;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use App\Nova\Flexible\Layouts\VideoLayout;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;
use App\Nova\Flexible\Layouts\AccordionLayout;
use App\Nova\Flexible\Layouts\CardSliderLayout;
use App\Nova\Flexible\Layouts\FeatureBoxLayout;
use App\Nova\Flexible\Layouts\SingleCardLayout;
use App\Nova\Flexible\Layouts\SingleTextLayout;
use App\Nova\Flexible\Layouts\HistoryCardLayout;
use App\Nova\Flexible\Layouts\ProgressBarLayout;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use App\Nova\Flexible\Layouts\WeddingCopiesLayout;

class Wedding extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Wedding>
     */
    public static $model = \App\Models\Wedding::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
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
            ID::make()->sortable(),
            Text::make('Name', 'name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Slug')
                ->exceptOnForms(),
            Flexible::make('Couple Names', 'couple_name')
                ->hideFromDetail()
                ->addLayout('Text', 'Text', [
                    Select::make('Title')
                        ->options([
                            'Mr' => 'Mr',
                            'Mrs' => 'Mrs',
                            'Ms' => 'Ms',
                            'Miss' => 'Miss',
                            'Sr' => 'Sr',
                            'Sra' => 'Sra',
                            'Srta' => 'Srta',
                        ])
                        ->rules('required'),
                    Text::make('Name')
                        ->rules('required', 'max:255'),
                    Boolean::make('Show Title', 'show_title')
                        ->default(false),
                ])->button('Add Couple Name')
                ->limit(2)
                ->confirmRemove()
                ->stacked(),
            Flexible::make('Content', 'content')
                ->hideFromDetail()
                ->fullWidth()
                ->menu(
                    'flexible-search-menu',
                    [
                        'selectLabel' => 'Press enter to select',
                        'label' => 'title',
                        'openDirection' => 'top',
                    ]
                )
                ->confirmRemove()
                ->collapsed()
                ->button('Add Content')
                ->addLayout(HistoryCardLayout::class)
                ->addLayout(WeddingCopiesLayout::class),
            Flexible::make('Date', 'date')
                ->addLayout('Date information', 'date_information', [
                    Text::make('Title', 'title')
                        ->rules('required', 'max:255'),
                    Text::make('Subtitle', 'subtitle')
                        ->rules('required', 'max:255'),
                    DateTime::make('Date', 'wedding_date')
                        ->resolveUsing(function ($value) {
                            return $value;
                        })
                        ->min(Carbon::tomorrow())
                        ->rules('required'),
                ])->button('Add Feature')
                ->confirmRemove()
                ->stacked()
                ->limit(1),
            Flexible::make('Location', 'location')
                ->hideFromDetail()
                ->fullWidth()
                ->addLayout('location information', 'location_information', [
                    Text::make('Place', 'place')
                        ->rules('required', 'max:255'),
                    Text::make('Address', 'address'),
                    Url::make('Google Maps Url', 'google_maps'),
                    Url::make('Waze Url', 'waze'),
                ])->button('Add Date')->limit(1),
            Images::make('Imagen Principal', 'main_image')
                ->hideFromDetail()
                ->hideFromIndex(),
            Images::make('Galería de Imágenes', 'gallery')
                ->hideFromDetail()
                ->hideFromIndex(),

            HasMany::make('Guests', 'guests', Guest::class),
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
        return [];
    }
}
