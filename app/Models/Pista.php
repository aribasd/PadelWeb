<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;




class Pista extends Model
{

 protected $table = 'pistes';

   use HasFactory;

        protected $fillable = [
        'nom',
        'activa',
        'doble_vidre',
    ];
    


  public function reserves()
  {
    return $this->belongsTo(Reserva::class);
  }
}


