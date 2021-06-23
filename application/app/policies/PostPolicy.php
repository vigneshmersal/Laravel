<?php
namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
	use HandlesAuthorization;

	/**
	 * authorize all actions
	 * It will executed before any other methods on the policy
	 */
	public function before($user, $ability)
	{
		if ($user->isAdmin()) return true;

		return $user->hasRole('manager');
	}

	/**
	* Index
	*/
	public function viewAny(User $user, Post $post)
	{
  		// return true;
		//   instead of return true/false
		//   you can pass custom messages
		return $this->deny('You are not permitted for this page.');
	}

	/**
	* Determine whether the user can view the post.
	*/
	public function view(User $user, Post $post)
	{
		return $user->permissions()->contains('create-user');
  		return $user->hasPermissionTo('view-users');
	}

	/**
	* Determine whether the user can create posts.
	*/
	public function create(User $user)
	{
		return optional($user)->id > 0;
		return $user->hasPermissionTo('create-users');
	}

	/**
	* Determine whether the user can update the post.
	*/
	public function update(User $user, Post $post)
	{
		return optional($user)->id == $post->user_id;
		return $user->hasPermissionTo('update-users');
	}

	/**
	* Determine whether the user can delete the post.
	*/
	public function delete(User $user, Post $post)
	{
		return $user->id == $post->user_id;
		return $user->hasPermissionTo('delete-users');
	}

	/**
	 * restore
	 * @param  [string]  [description]
	*/
	public function restore(User $user)
	{
		return true;
	}

	/**
	 * forceDelete
	 * @param  [string]  [description]
	*/
	public function forceDelete(User $user)
	{
		return true;
	}
}
