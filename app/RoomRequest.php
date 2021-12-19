<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRequest extends Model
{
    protected $fillable = [
        'hospital_room_id', 'occupant_id' , 'type', 'status'
   ];

//    protected $hidden = [
//   'created_at', 'updated_at'
//    ];


   public function occupant()
   {
       return $this->belongsTo(Occupant::class);
   }
   public function hospital_room()
   {
       return $this->belongsTo(HospitalRoom::class);
   }
}

