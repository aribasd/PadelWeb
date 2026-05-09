<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reserva extends Model
{
       protected $table = 'reserves';

       use HasFactory;

       protected $fillable = ['pista_id', 'user_id', 'data', 'hora_inici', 'hora_fi', 'preu'];

    protected static function booted(): void
    {
        // En esborrar una reserva, esborrem també el partit que hi pugui haver vinculat
        // (la reserva és el "contenidor", el partit només té sentit dins una reserva).
        static::deleting(function (Reserva $reserva) {
            $reserva->partits()->delete();
        });
    }


    public function users()
    {
        // FK explícita: la columna és `user_id` (no `users_id` que és el que
        // intentaria endevinar Laravel pel nom plural del mètode).
        return $this->belongsTo(User::class, 'user_id');
    }

    public function partits()
    {
        return $this->hasOne(Partit::class);
    }

    public function pistes()
    {
        return $this->belongsTo(Pista::class);
    }
}
