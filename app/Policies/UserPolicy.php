<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * 用户编辑权限判定
     * 当前用户只能编辑自己的资料
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        // 逻辑
        return $user->id === $model->id;
    }

    /**
     * 删除用户
     * 只有管理员可以删除，并且管理员不能删除自己
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        // 逻辑
        return $user->is_admin && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
