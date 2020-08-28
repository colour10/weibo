<?php

namespace App\Http\Requests;

/**
 * 登录及退出
 *
 * Class SessionRequest
 * @package App\Http\Requests
 */
class SessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
    }
}
