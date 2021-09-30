<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Occupant extends Model
{
    protected $fillable = [
        'user_id', 'name'
    ];

    protected $hidden = [
     'created_at', 'updated_at'
    ];

    public function roomRequest()
    {
        return $this->hasMany(RoomRequest::class);
    }
}
