<?php

namespace App\Http\Requests;

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
        return [
            'name'     => 'required|string|unique:users|max:50',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ];
    }
}
