<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupant extends Model
{
    protected $fillable = [
        'user_id', 'name', 'type', 'status', 'address', 'number'
    ];

    protected $hidden = [
     'created_at', 'updated_at'
    ];

    public function room()
    {
        return $this->belongsTo(HospitalRoom::class);
    }

    public function roomRequest()
    {
        return $this->belongsTo(RoomRequest::class);
    }
}
