<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insignia extends Model
{
        public function perfil_estadistiques()
    {
        return $this->belongsTo(PerfilEstadistica::class);
    }
}
