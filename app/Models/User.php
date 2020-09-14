<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


/**
 * App\Models\User
 *
 * @property int $id 主键ID
 * @property string $name 用户名
 * @property string $email 邮箱
 * @property \Illuminate\Support\Carbon|null $email_verified_at 邮箱验证时间
 * @property string $password 密码
 * @property int $is_admin 是否为管理员：
 * @property string|null $remember_token 登录token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $activation_token email验证token
 * @property int $is_activated email是否已验证：0-未验证；1-已验证
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActivationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActivated($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Microblog[] $microblogs
 * @property-read int|null $microblogs_count
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 返回头像
     *
     * @param int $size
     * @return string
     */
    public function gravatar($size = 100)
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return 'http://www.gravatar.com/avatar/' . $hash . '?s=' . $size;
    }

    /**
     * 模型事件监听
     */
    public static function boot()
    {
        parent::boot();

        // 生成验证 email token 字符串
        static::creating(function ($user) {
            $user->activation_token = Str::random(10);
        });
    }

    // 发布者-微博，一对多
    public function microblogs()
    {
        return $this->hasMany(Microblog::class);
    }

    /**
     * 微博倒序排列
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feed()
    {
        return $this->microblogs()
            ->orderBy('created_at', 'desc');
    }

    // 用户关注的人
    public function followings()
    {
        // 逻辑
        return $this->belongsToMany(self::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    // 用户的粉丝
    public function followers()
    {
        // 逻辑
        return $this->belongsToMany(self::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    /**
     * 用户关注行为
     *
     * @param $user_ids
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 用户取消关注行为
     *
     * @param $user_ids
     */
    public function unFollow($user_ids)
    {
        // 逻辑
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断当前登录用户是否关注了某一个用户
     *
     * @param $user_id
     * @return boolean
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
