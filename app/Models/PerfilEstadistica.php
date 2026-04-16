<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class PerfilEstadistica extends Model
{

    use HasFactory;

        protected $table = 'perfil_estadistiques';


        protected $fillable = [
        'partits_jugats',
        'win_rate',
        'nivell',
        'data_naixament',
        'foto_perfil',
    ];
    
        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function insignies()
    {
        return $this->hasMany(Insignia::class, 'perfil_estadistica_id');
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
