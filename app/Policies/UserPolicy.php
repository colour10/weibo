<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

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
     * 关注用户
     * 只能关注自己以外的用户
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return mixed
     */
    public function follow(User $user, User $model)
    {
        // 逻辑
        return $user->id !== $model->id;
    }
}
