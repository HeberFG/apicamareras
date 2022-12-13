<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    use HasFactory;

    protected $table = 'observations';

    protected $fillable = ['id', 'text', 'evidencies', 'room_id', 'created_at', 'updated_at'];

    protected $hidden = [];

    public function findObservationById($id)
    {
        return Observation::find($id);
    }

    public function room(){
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
