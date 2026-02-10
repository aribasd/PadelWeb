<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
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
        return $this->hasOne(Pista::class);
    }
}
