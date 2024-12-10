<?php

namespace App\Providers;

use App\Nova\User;
use App\Nova\Country;
use App\Nova\Wedding;
use Laravel\Nova\Nova;
use App\Nova\GuestType;
use App\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
use Oneduo\NovaFileManager\NovaFileManager;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::withBreadcrumbs();
        Nova::footer(function ($request) {
            return Blade::render('nova.footer');
        });
        Nova::mainMenu(function ($request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),
                MenuSection::make('Admin', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Country::class),
                    MenuItem::resource(GuestType::class),
                ])->icon('adjustments')->collapsable(),
                MenuSection::make('Weddiings', [
                    MenuItem::resource(Wedding::class)
                ])->collapsable(),
                MenuSection::make('Log Viwer', [
                    MenuItem::link('Dashboard', '/nova-logs/dashboard'),
                    MenuItem::link('Logs', '/nova-logs/list'),
                ])->collapsable()
                    ->icon('document-text'),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            if (env('APP_ENV') === 'production') {
                $novaUsers = explode(',', config('nova.nova_users'));
                return in_array($user->email, $novaUsers);
            }
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            NovaFileManager::make(),
            new \PhpJunior\NovaLogViewer\Tool(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
