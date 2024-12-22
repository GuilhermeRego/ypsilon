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
        // Allow viewing if the user is an admin
        if ($user->isAdmin()) {
            return true;
        }
    
        // Allow viewing if the user is the author
        if ($user->id === $post->user_id) {
            return true;
        }
    
        // Allow viewing if the post's user account is not private
        if (!$post->user->is_private) {
            return true;
        }
    
        // If the account is private, check if the current user follows the author
        if ($post->user->is_private && !$user->following->contains('followed_id', $post->user_id)) {
            return false;
        }
    
        return false;
    }
}
