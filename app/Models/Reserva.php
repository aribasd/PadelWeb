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
        static::deleting(function (Reserva $reserva) {
            $reserva->partits()->delete();
        });
    }


    public function users()
    {
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
