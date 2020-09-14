<?php

namespace App\Http\Controllers;

use App\Http\Requests\MicroblogRequest;
use App\Models\Microblog;
use Auth;

class MicroblogController extends Controller
{
    /**
     * 构造函数
     *
     * MicroblogController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 微博保存
     *
     * @param MicroblogRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MicroblogRequest $request)
    {
        // 逻辑
        Auth::user()->microblogs()->create([
            'content' => $request->input('content'),
        ]);
        session()->flash('success', '发布成功');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Microblog $microblog
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Microblog $microblog)
    {
        $this->authorize('delete', $microblog);
        $microblog->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
