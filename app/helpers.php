<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('acting_user')) {
    /**
     * The user actions are attributed to.
     *
     * Logged in  -> the authenticated user (the dev, "Jesús").
     * Guest      -> the default user ("Rey"), so browsing without login
     *               behaves as Rey (only sees visible items).
     */
    function acting_user(): ?User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        // Return the default "Rey" user for guests
        return User::where('role', 'dev')->first();
    }
}

if (! function_exists('can_see_hidden')) {
    /**
     * Whether the current visitor may see items hidden from the jefe.
     * Only a logged-in user (the dev) can.
     */
    function can_see_hidden(): bool
    {
        return Auth::check();
    }
}
