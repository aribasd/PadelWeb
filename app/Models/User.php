<?php

namespace App\Models;

use App\Models\Comunitat;
use App\Models\Friendship;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'avatar_path',

    ];

    /*------Relacions Taules--------*/


    
    public function reserves()
    {
        return $this->hasMany(Reserva::class);
    }

        public function perfil_estadistiques()
    {
        return $this->hasOne(PerfilEstadistica::class, 'user_id');
    }

    public function comunitats()
    {
        return $this->belongsToMany(Comunitat::class)->withPivot('rol')->withTimestamps();
    }

    /**
     * Amics amb sol·licitud acceptada (taula `amistats`).
     *
     * @return \Illuminate\Support\Collection<int, User>
     */
    public function amicsAcceptats()
    {
        $ids = Friendship::query()
            ->where('estat', 'accepted')
            ->where(function ($q) {
                $q->where('emissor_id', $this->id)
                    ->orWhere('receptor_id', $this->id);
            })
            ->get()
            ->map(fn (Friendship $f) => $f->otherUserId((int) $this->id))
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return collect();
        }

        return static::query()
            ->whereIn('id', $ids)
            ->orderBy('name')
            ->get();
    }

    /**
     * Sol·licituds d’amistat rebudes (pendents d’acceptar).
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Friendship>
     */
    public function sollicitudsAmistatPendents()
    {
        return Friendship::query()
            ->where('receptor_id', $this->id)
            ->where('estat', 'pending')
            ->with('emissor')
            ->orderByDesc('created_at')
            ->get();
    }

    public function missatges()
    {
        return $this->hasMany(Missatge::class);
    }



    /*------------------------------*/


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
