<?php

namespace App\Policies;

use App\Eloquent\Post;
use App\Eloquent\Role;
use App\Eloquent\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PostPolicy
 * @package App\Policies
 */
class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * @param User $user
	 * @return bool
	 */
	public function get(User $user)
	{
		return $user->id > 0;
	}

    /**
     * Determine if user can be create post.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user)
    {
        $role = Role::where('name', 'admin')->first();

        return intval($user->role_id) === intval($role->id);
    }
}
