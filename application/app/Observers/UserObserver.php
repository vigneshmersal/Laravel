<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function creating(Post $post)
    {
        $post->user_id = auth()->id();
    }

    public function created(User $user)
    {
        $user->update([
            'employeeid' => "IG0".$user->id
        ]);
    }

    public function updated(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
