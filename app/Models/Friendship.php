<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    protected $table = 'amistats';

    protected $fillable = [
        'emissor_id',
        'receptor_id',
        'estat',
    ];

    public function emissor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'emissor_id');
    }

    public function receptor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }

    /**
     * Qualsevol fila entre els dos usuaris (en qualsevol sentit).
     */
    public static function betweenUsers(int $a, int $b): ?self
    {
        return static::query()
            ->where(function ($q) use ($a, $b) {
                $q->where(function ($q2) use ($a, $b) {
                    $q2->where('emissor_id', $a)->where('receptor_id', $b);
                })->orWhere(function ($q2) use ($a, $b) {
                    $q2->where('emissor_id', $b)->where('receptor_id', $a);
                });
            })
            ->first();
    }

    public function otherUserId(int $userId): int
    {
        return (int) ($this->emissor_id === $userId ? $this->receptor_id : $this->emissor_id);
    }
}
