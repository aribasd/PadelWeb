<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilEstadistica extends Model
{
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
