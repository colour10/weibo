<?php

namespace App\Models;

/**
 * App\Models\Microblog
 *
 * @property int $id 主键ID
 * @property int $user_id 发布者ID
 * @property string $content 内容
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Microblog whereUserId($value)
 * @mixin \Eloquent
 */
class Microblog extends Model
{
    // 预加载
    protected $with = ['user'];

    // 微博-发布者，一对多反向
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
