<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Insignia extends Model
{

  use HasFactory;

        protected $fillable = [
        'nom',
        'dificultats',
    ];

        public function perfil_estadistiques()
    {
        return $this->belongsTo(PerfilEstadistica::class);
    }
}
