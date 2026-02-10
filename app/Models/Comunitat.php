<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunitat extends Model
{
    public function perfil_estadistiques()
    {
        return $this->belongTo(PerfilEstadistica::class);
    }
}
