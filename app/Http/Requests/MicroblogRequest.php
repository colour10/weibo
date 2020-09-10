<?php

namespace App\Http\Requests;

/**
 * 微博验证类
 *
 * Class UserRequest
 *
 * @package App\Http\Requests
 */
class MicroblogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
        ];
    }
}
