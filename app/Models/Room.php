<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = ['id', 'number', 'type', 'floor', 'state', 'user_id', 'build_id', 'created_at', 'updated_at'];

    protected $hidden = [];

    public function findRoomById($id)
    {
        return Room::find($id);
    }

    public function user(){
         
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function build(){
         
        return $this->belongsTo(Build::class, 'build_id', 'id');
    }

    public function services(){
         return $this->belongsToMany(
            Service::class,  
            'rooms_services',  
            'rooms_id',  
            'services_id' 
        );
    }

    public function observations(){
        return $this->hasMany(Observation::class);
    }
}
