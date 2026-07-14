<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('acting_user')) {
    /**
     * The user actions are attributed to.
     *
     * Logged in  -> the authenticated user (the dev, "Jesús Blondell").
     * Guest      -> the default boss ("jefe") user, so browsing without
     *               login behaves as the jefe.
     */
    function acting_user(): ?User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        return null;
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
