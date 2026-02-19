<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable = ['name'];

    //Relacion uno a muchos
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
