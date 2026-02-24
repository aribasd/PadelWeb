<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comunitat extends Model
{

  use HasFactory;

        protected $fillable = [
            'nom',
    ];

    public function perfil_estadistiques()
    {
        return $this->belongTo(PerfilEstadistica::class);
    }
}
    