<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Qualsevol fila entre els dos usuaris (en qualsevol sentit).
     */
    public static function betweenUsers(int $a, int $b): ?self
    {
        return static::query()
            ->where(function ($q) use ($a, $b) {
                $q->where(function ($q2) use ($a, $b) {
                    $q2->where('sender_id', $a)->where('receiver_id', $b);
                })->orWhere(function ($q2) use ($a, $b) {
                    $q2->where('sender_id', $b)->where('receiver_id', $a);
                });
            })
            ->first();
    }

    public function otherUserId(int $userId): int
    {
        return (int) ($this->sender_id === $userId ? $this->receiver_id : $this->sender_id);
    }
}
