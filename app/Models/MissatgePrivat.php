<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissatgePrivat extends Model
{
    protected $table = 'missatges_privats';

    protected $fillable = [
        'emissor_id',
        'receptor_id',
        'missatge',
    ];

    public function emissor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'emissor_id');
    }

    public function receptor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }
}

