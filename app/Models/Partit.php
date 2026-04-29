<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;



class Partit extends Model
{

  use HasFactory;

        protected $fillable = [
        'nom1',
        'nom2',
        'nom3',
        'nom4',
        'set1',
        'set2',
        'set3',
        'reserva_id',
    ];

        public function reserves()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function pistes()
    {
        return $this->belongsTo(Pista::class);
    }
}