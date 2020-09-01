<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Microblog extends Model
{
    // 微博-发布者，一对多反向
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
