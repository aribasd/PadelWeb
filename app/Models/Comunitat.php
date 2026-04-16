<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Missatge;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comunitat extends Model
{

  use HasFactory;

        protected $fillable = [
            'nom',
            'descripcio',
            'imatge',
            'membres',
            'rol',
    ];

    public function perfil_estadistiques()
    {
        return $this->belongTo(PerfilEstadistica::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('rol')->withTimestamps();
    }

    public function missatges()
    {
        return $this->hasMany(Missatge::class);
    }
}
    