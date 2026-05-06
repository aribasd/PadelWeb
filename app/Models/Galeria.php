<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galeria extends Model
{
    protected $table = 'galeria';

    protected $fillable = [
        'imatge',
        'comunitat_id',
    ];

    public function comunitat(): BelongsTo
    {
        return $this->belongsTo(Comunitat::class, 'comunitat_id');
    }
}
