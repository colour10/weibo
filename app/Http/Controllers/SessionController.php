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
        $authentication = $request->only(['email', 'password']);
        // 登录成功
        if (Auth::attempt($authentication, $request->has('remember'))) {
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
        Auth::logout();
        session()->flash('success', '您已成功退出');
        return redirect()->route('home');
    }
}
