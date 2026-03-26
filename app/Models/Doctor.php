<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'speciality_id',
        'medical_license_number',
        'biography',
    ];

    //Relacion uno a uno inversa
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relacion uno a uno inversa
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    //Relación uno a muchos: un doctor tiene muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
