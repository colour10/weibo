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
        // 如果登录失败
        if (!Auth::attempt($authentication, $request->has('remember'))) {
            // 登录失败
            session()->flash('danger', '很抱歉，账号和密码不匹配');
            return redirect()->back()->withInput();
        }
        // 如果登录成功，那么检查邮箱是否已经激活, 否则注销退出
        if (!Auth::user()->is_activated) {
            Auth::logout();
            session()->flash('danger', '您的邮箱暂未激活，请激活后再来登录');
            return redirect('/');
        }
        // 到这里，说明完全正确，登录成功
        session()->flash('success', '恭喜您，登录成功');
        // 定义上一次尝试访问的地址
        $fallback = route('users.show', ['user' => Auth::user()]);
        return redirect()->intended($fallback);

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
