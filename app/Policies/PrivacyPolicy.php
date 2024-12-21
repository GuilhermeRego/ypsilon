<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PrivacyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $user, Post $post)
    {
        if ($user->isAdmin()) {
            return true;
        }

        // If the user is the author, allow viewing
        if ($user->id === $post->user_id) {
            return true;
        }

        // If the post's user account is not private, allow viewing
        if (!$post->user->is_private) {
            return true;
        }

        // If the account is private, check if the current user follows the author
        if ($post->user->is_private && !$user->following->contains('followed_id', $post->user_id)) {
            return false;
        }

        return true;
    }
}
