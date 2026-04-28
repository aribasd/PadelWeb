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
            if ($existing->status === 'accepted') {
                return back()->withErrors(['receiver_id' => 'Ja sou amics.']);
            }
            if ($existing->status === 'pending') {
                return back()->withErrors(['receiver_id' => 'Ja hi ha una sol·licitud pendent.']);
            }
            if ($existing->status === 'declined') {
                $existing->delete();
            }
        }

        Friendship::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

        return back();
    }

    public function accept(Friendship $friendship): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        abort_unless($friendship->receiver_id === $user->id, 403);
        abort_unless($friendship->status === 'pending', 400);

        $friendship->update(['status' => 'accepted']);

        return back();
    }

    public function decline(Friendship $friendship): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        abort_unless($friendship->receiver_id === $user->id, 403);
        abort_unless($friendship->status === 'pending', 400);

        $friendship->update(['status' => 'declined']);

        return back();
    }

    public function destroy(Friendship $friendship): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user instanceof User, 403);

        $involved = $friendship->sender_id === $user->id || $friendship->receiver_id === $user->id;
        abort_unless($involved, 403);

        $friendship->delete();

        return back();
    }
}
