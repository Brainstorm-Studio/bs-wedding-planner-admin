<?php

namespace App\Nova\Actions;

use App\Models\Lead\Lead;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendWhatsapp extends Action
{
    use InteractsWithQueue,
        Queueable,
        SerializesModels;

    // public $name = 'Enviar Whatsapp al cliente';

    public function handle(ActionFields $fields, Collection $models)
    {

        if ($models->count() != 1) {
            return Action::danger('Esta acción solo se puede ejecutar en un solo registro a la vez.');
        }

        $model = $models->first();

        $guest_phone = $model->phone;
        $country_code = $model->country->phone_code;
        $whatsapp_number = $country_code . $guest_phone;
        $guest_name = $model->guest_name . ' ' . $model->couple_name;
        $invite_url = 'https://www.nuestraboda-esteban-y-fernanda.com/';
        $header_message = 'Estimad@ ' . '*' . $guest_name . '*' . ', tenemos el honor de invitarlos a nuestra boda. Por favor confirma tu asistencia en el siguiente enlace: https://www.nuestraboda-esteban-y-fernanda.com/';
        $whatsapp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . $header_message . '%0A' . urlencode($fields->message);

            return Action::openInNewTab($whatsapp_url);
    }

    public function fields(NovaRequest $request)
    {
        return [
            // Textarea::make('Mensaje', 'message')
            //     ->rows(2)
            //     ->rules('required', 'max:255'),
        ];
    }

}
