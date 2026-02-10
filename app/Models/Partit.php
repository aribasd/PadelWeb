<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partit extends Model
{
        public function reserves()
    {
        return $this->belongsTo(Reserva::class);
    }
}
