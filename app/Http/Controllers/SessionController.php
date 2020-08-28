<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use Illuminate\Support\Facades\Auth;

/**
 * 公共操作
 *
 * Class SessionController
 * @package App\Http\Controllers
 */
class SessionController extends Controller
{
    /**
     * 注册页
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 注册逻辑
     *
     * @param SessionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SessionRequest $request)
    {
        // 逻辑
        // 登录成功
        if (Auth::attempt($request->except('_token'), true)) {
            session()->flash('success', '恭喜您，登录成功');
            return redirect()->route('users.show', ['user' => Auth::user()]);
        }
        // 登录失败
        session()->flash('danger', '很抱歉，账号和密码不匹配');
        return redirect()->back()->withInput();

    }

    /**
     * 退出
     */
    public function destroy()
    {

    }
}
