<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class UserController extends Controller
{
    /**
     * 构造函数
     *
     * UserController constructor.
     */
    public function __construct()
    {
        // 不需要通过 auth 中间件过滤的路由列表
        $this->middleware('auth', [
            'except' => [
                'index',
                'show',
                'create',
                'store',
                'confirmEmail',
            ],
        ]);

        // 只允许游客访问的路由
        $this->middleware('guest', [
            'only' => [
                'create',
            ],
        ]);
    }

    /**
     * 用户列表展示
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        // 逻辑
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 用户注册逻辑
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        // 逻辑
        // 写入新用户
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // 发送激活邮件并返回
        $this->sendEmail($user);
        session()->flash('success', '您已注册成功，请到邮箱激活您的账号');
        return redirect()->route('users.show', compact('user'));
    }

    /**
     * 发送激活短信
     *
     * @param $user
     */
    protected function sendEmail($user)
    {
        // 逻辑
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    /**
     * 用户邮箱激活
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmEmail($token)
    {
        // 逻辑
        // 存在则激活
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->is_activated = true;
        $user->activation_token = null;
        // 添加邮箱激活时间
        $user->email_verified_at = Carbon::now();
        $user->save();

        // 自动登录
        Auth::login($user);
        session()->flash('success', '恭喜您，邮箱激活成功');
        return redirect()->route('users.show', compact('user'));
    }

    /**
     * 用户查看页面
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(User $user)
    {
        // 逻辑，查出当前用户发布的所有微博
        $microblogs = $user
            ->microblogs()
            ->orderByDesc('created_at')
            ->paginate(10);
        // 渲染
        return view('users.show', compact('user', 'microblogs'));
    }

    /**
     * 用户编辑页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 用户编辑逻辑
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|Request
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        // 验证
        $this->authorize('update', $user);
        $this->validate($request, [
            'name'     => 'required|string|unique:users,name,' . $user->id . '|max:50',
            'password' => 'nullable|confirmed|min:6',
        ]);
        // 逻辑
        $data['name'] = $request->input('name');
        if ($request->input('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }
        // 更新
        $user->update($data);
        session()->flash('success', '资料更新成功');
        return redirect()->route('users.show', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        // 逻辑
        $user->delete();
        session()->flash('success', '用户已成功删除');
        $fallback = route('users.index');
        return redirect()->intended($fallback);
    }

    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = $user->name . '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name . '的粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }
}
