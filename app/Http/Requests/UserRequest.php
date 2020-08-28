<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Request;

/**
 * 用户验证类
 *
 * Class UserRequest
 *
 * @package App\Http\Requests
 */
class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 判断提交方式
        // 如果是 post，则是注册逻辑
        if (Request::method() == 'POST') {
            return [
                'name'     => 'required|string|unique:users|max:50',
                'email'    => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
            ];
        }
    }
}
