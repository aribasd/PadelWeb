<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Insignia extends Model
{

  use HasFactory;

        protected $table = 'insignies';

        protected $fillable = [
        'nom',
        'dificultat',
        'perfil_estadistica_id',
    ];

        public function perfil_estadistica()
    {
        return $this->belongsTo(PerfilEstadistica::class, 'perfil_estadistica_id');
    }
}
