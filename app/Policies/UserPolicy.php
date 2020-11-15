<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function update(User $user,User $model)
    {
        return $user->id==$model->id;
    }

    public function destroy(User $user,User $model){
        return $user->is_admin && $user->id != $model->id;
    }

    public function follow(User $user,User $model)
    {
        return $user->id!=$model->id;
    }
}
