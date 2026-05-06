<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
        ]);

        $sender = Auth::user();
        abort_unless($sender instanceof User, 403);

        $receiver = User::findOrFail((int) $validated['receiver_id']);

        if ($sender->id === $receiver->id) {
            return back()->withErrors(['receiver_id' => 'No et pots enviar una sol·licitud a tu mateix.']);
        }

        $existing = Friendship::betweenUsers($sender->id, $receiver->id);

        if ($existing) {
            if ($existing->estat === 'accepted') {
                return back()->withErrors(['receiver_id' => 'Ja sou amics.']);
            }
            if ($existing->estat === 'pending') {
                return back()->withErrors(['receiver_id' => 'Ja hi ha una sol·licitud pendent.']);
            }
            if ($existing->estat === 'declined') {
                $existing->delete();
            }
        }

        Friendship::create([
            'emissor_id' => $sender->id,
            'receptor_id' => $receiver->id,
            'estat' => 'pending',
        ]);

        return back();
    }

    public function accept(Friendship $friendship): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        abort_unless($friendship->receptor_id === $user->id, 403);
        abort_unless($friendship->estat === 'pending', 400);

        $friendship->update(['estat' => 'accepted']);

        return back();
    }

    public function decline(Friendship $friendship): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        abort_unless($friendship->receptor_id === $user->id, 403);
        abort_unless($friendship->estat === 'pending', 400);

        $friendship->update(['estat' => 'declined']);

        return back();
    }

    public function destroy(Friendship $friendship): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        $involved = $friendship->emissor_id === $user->id || $friendship->receptor_id === $user->id;
        abort_unless($involved, 403);

        $friendship->delete();

        return back();
    }
}
