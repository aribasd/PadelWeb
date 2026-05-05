<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\MissatgePrivat;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectMessageController extends Controller
{
    public function index(Request $request, ?User $user = null)
    {
        $me = Auth::user();
        abort_unless($me instanceof User, 403);

        $amics = $me->amicsAcceptats();

        $amicSeleccionat = null;
        $missatges = collect();

        if ($user) {
            $isFriend = Friendship::betweenUsers((int) $me->id, (int) $user->id);
            abort_unless($isFriend && $isFriend->status === 'accepted', 403);

            $amicSeleccionat = $user;

            $missatges = MissatgePrivat::query()
                ->where(function ($q) use ($me, $user) {
                    $q->where('emissor_id', $me->id)->where('receptor_id', $user->id);
                })
                ->orWhere(function ($q) use ($me, $user) {
                    $q->where('emissor_id', $user->id)->where('receptor_id', $me->id);
                })
                ->with(['emissor'])
                ->orderBy('created_at')
                ->limit(200)
                ->get();
        }

        return view('social.messages', [
            'amics' => $amics,
            'amicSeleccionat' => $amicSeleccionat,
            'missatges' => $missatges,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $me = Auth::user();
        abort_unless($me instanceof User, 403);

        $isFriend = Friendship::betweenUsers((int) $me->id, (int) $user->id);
        abort_unless($isFriend && $isFriend->status === 'accepted', 403);

        $validated = $request->validate([
            'missatge' => ['required', 'string', 'max:500'],
        ]);

        MissatgePrivat::create([
            'emissor_id' => $me->id,
            'receptor_id' => $user->id,
            'missatge' => $validated['missatge'],
        ]);

        return redirect()
            ->route('social.missatges', $user)
            ->withFragment('bottom');
    }
}

