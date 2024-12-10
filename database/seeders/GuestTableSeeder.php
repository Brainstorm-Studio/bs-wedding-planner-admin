<?php

namespace Database\Seeders;


use App\Models\Guest;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuestTableSeeder extends Seeder
{
    public function run()
    {
        $json = file_get_contents(base_path('database/json/wedding-guests.json'));

        $guests = json_decode($json);

        foreach($guests as $guest){
            Guest::create([
                'id' => $guest->id,
                'wedding_id' => $guest->wedding_id,
                'guest_type_id' => $guest->guest_type_id,
                'country_id' => $guest->country_id,
                'guest_name' => $guest->guest_name,
                'couple_name' => $guest->couple_name,
                'email' => $guest->email,
                'phone' => $guest->phone,
                'rsvp' => $guest->rsvp,
                'with_plus_one' => $guest->with_plus_one,
                'allergies' => $guest->allergies,
                'deleted_at' => $guest->deleted_at,
                'created_at' => $guest->created_at,
                'updated_at' => $guest->updated_at,
                'rsvp_date' => $guest->rsvp_date,
                'has_allergies' => $guest->has_allergies,
                'note' => $guest->note,
                'plus_one_count' => $guest->plus_one_count,
                'total_confirmed' => $guest->total_confirmed,
            ]);
        }

        $maxId = Guest::max('id');
        DB::statement("SELECT setval(pg_get_serial_sequence('guests', 'id'), ?, false)", [$maxId]);

    }
}
