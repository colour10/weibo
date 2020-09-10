<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Model基类
 *
 * Class Model
 * @package App\Models
 */
class Model extends BaseModel
{
    // 黑名单-无
    protected $guarded = [];
}
