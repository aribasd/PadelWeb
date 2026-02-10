<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pista extends Model
{
  public function reserves()
  {
    return $this->belongsTo(Reserva::class);
  }
}
