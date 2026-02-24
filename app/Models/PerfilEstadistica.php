<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class PerfilEstadistica extends Model
{

    use HasFactory;

        protected $fillable = [
        'partits_jugats',
        'win_rate',
        'nivell',
        'data_naixament',
        'foto_perfil',
    ];
    
        public function users()
    {
        return $this->belongsTo(User::class);
    }

        public function insignies()
    {
        return $this->hasMany(Insignia::class);
    }
    
    public function comunitats()
    {
        return $this->hasOne(Comunitat::class);
    }

        public function xats()
    {
        return $this->hasOne(Xat::class);
    }

}
