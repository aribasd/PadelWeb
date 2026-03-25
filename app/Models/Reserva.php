<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reserva extends Model
{
       protected $table = 'reserves';

       use HasFactory;

       protected $fillable = ['pista_id', 'data', 'hora_inici', 'hora_fi', 'preu'];
    

    public function users()
    {
        return $this->belongsTo(User::class);
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
