<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['id', 'name','created_at', 'updated_at'];

    protected $hidden = ['id'];

    public function findServiceById($id)
    {
        return Service::find($id);
    }
}
