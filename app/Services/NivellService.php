<?php

namespace App\Services;

use App\Models\PerfilEstadistica;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class NivellService
{
    public const MAX_LEVEL = 100;

    public function awardXp(User $user, int $xp): PerfilEstadistica
    {
        $perfil = $this->getOrCreatePerfil($user);
        if (! Schema::hasColumn('perfil_estadistiques', 'experiencia')) {
            return $perfil;
        }

        $perfil->experiencia = (int) ($perfil->experiencia ?? 0) + max(0, $xp);

        $nouNivell = $this->levelForXp((int) $perfil->experiencia);
        if ($nouNivell !== (int) $perfil->nivell) {
            $perfil->nivell = $nouNivell;
        }

        $perfil->save();

        return $perfil;
    }

    public function levelForXp(int $xp): int
    {
        $xp = max(0, $xp);

        for ($lvl = 1; $lvl < self::MAX_LEVEL; $lvl++) {
            if ($xp < $this->xpRequiredForLevel($lvl + 1)) {
                return $lvl;
            }
        }

        return self::MAX_LEVEL;
    }

    public function xpRequiredForLevel(int $level): int
    {
        $level = max(1, min(self::MAX_LEVEL, $level));

        $base = 80.0;
        $growth = 1.06;

        if ($level === 1) {
            return 0;
        }

        $n = $level - 2;
        $sum = $base * ((pow($growth, $n + 1) - 1) / ($growth - 1));

        return (int) round($sum);
    }

    public function progressToNextLevel(PerfilEstadistica $perfil): array
    {
        $lvl = (int) $perfil->nivell;
        $xp = (int) ($perfil->experiencia ?? 0);

        if ($lvl >= self::MAX_LEVEL) {
            return [
                'level' => self::MAX_LEVEL,
                'xp' => $xp,
                'currentLevelXp' => $this->xpRequiredForLevel(self::MAX_LEVEL),
                'nextLevelXp' => $this->xpRequiredForLevel(self::MAX_LEVEL),
                'progress' => 100,
            ];
        }

        $currentLevelXp = $this->xpRequiredForLevel($lvl);
        $nextLevelXp = $this->xpRequiredForLevel($lvl + 1);
        $den = max(1, $nextLevelXp - $currentLevelXp);
        $pct = (int) floor(min(100, max(0, (($xp - $currentLevelXp) / $den) * 100)));

        return [
            'level' => $lvl,
            'xp' => $xp,
            'currentLevelXp' => $currentLevelXp,
            'nextLevelXp' => $nextLevelXp,
            'progress' => $pct,
        ];
    }

    private function getOrCreatePerfil(User $user): PerfilEstadistica
    {
        $perfil = $user->perfil_estadistiques;
        if ($perfil instanceof PerfilEstadistica) {
            if (Schema::hasColumn('perfil_estadistiques', 'user_id') && ! $perfil->user_id) {
                $perfil->user_id = $user->id;
                $perfil->save();
            }
            return $perfil;
        }

        $data = [
            'partits_jugats' => 0,
            'win_rate' => 0,
            'nivell' => 1,
            'data_naixament' => now()->toDateString(),
            'foto_perfil' => null,
        ];

        if (Schema::hasColumn('perfil_estadistiques', 'user_id')) {
            $data['user_id'] = $user->id;
        }
        if (Schema::hasColumn('perfil_estadistiques', 'experiencia')) {
            $data['experiencia'] = 0;
        }

        return PerfilEstadistica::query()->create($data);
    }
}

