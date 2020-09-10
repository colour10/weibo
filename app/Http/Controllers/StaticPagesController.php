<?php

namespace App\Http\Controllers;

use Auth;

/**
 * 单页
 *
 * Class StaticPagesController
 * @package App\Http\Controllers
 */
class StaticPagesController extends Controller
{
    /**
     * 首页
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(10);
        }
        // 渲染模板
        return view('static_pages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('static_pages/help');
    }

    public function about()
    {
        return view('static_pages/about');
    }
}
