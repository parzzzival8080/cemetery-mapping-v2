<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomRequest extends Model
{
    protected $fillable = [
        'occupant_id', 'hostpital_room_id', 'type'
   ];

   protected $hidden = [
    'occupant_id', 'room_id', 'created_at', 'updated_at'
   ];

   public function occupant()
   {
       return $this->belongsTo(Occupant::class);
   }
   public function hospital_room()
   {
       return $this->belongsTo(HospitalRoom::class);
   }
}

