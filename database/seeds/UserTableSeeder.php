<?php

use App\Hospital;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'username' => 'administrator',
            'password' => 'administrator',
            'username' => 'administrator',
            'role' => 'ADMINISTRATOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        /** Customer */
        $userHospital = User::create([
            'username' => 'hospital',
            'password' => 'hospital',
            'username' => 'hospital',
            'role' => 'HOSPITAL',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $hospital =  Hospital::create([
            'name' => 'EJ Lumata',
            'number' => '09664375522',
            'user_id' => $userHospital->id,
            'address' => 'Pasonanca, Zamboanga City',
            'longitude' => 0,
            'latitude' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $hospitalRoom = \App\HospitalRoom::create([
            'hospital_id' => $hospital->id,
            'room_no' => 'ROOM 1',
            'status' => 'VACANT',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $userOccupant = \App\User::create([
            'username' => 'occupant',
            'password' => 'occupant',
            'username' => 'occupant',
            'role' => 'OCCUPANT',
            'created_at' => now(),
            'updated_at' => now()
        ]);


        $occupant = \App\Occupant::create([
            'name' => 'Alfadzry Jumli',
            'user_id' => $userHospital->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // $roomRequest = \App\RoomRequest::create([
        //     'hospital_room_id' => $hospitalRoom->id,
        //     'occupant_id' => $occupant->id,
        //     'type' => 'NON_COVID',
        //     'status' => 'CONFINED',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
