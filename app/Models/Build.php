<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    use HasFactory;

    protected $table = 'buildings';

    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];

    protected $hidden = [];

    public function findBuildById($id)
    {
        return Build::find($id);
    }

    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
