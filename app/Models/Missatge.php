<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Comunitat;
use App\Models\User;

class Missatge extends Model
{
    use HasFactory;

    protected $fillable = [
        'comunitat_id',
        'user_id',
        'missatge',
    ];

    public function comunitat()
    {
        return $this->belongsTo(Comunitat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
