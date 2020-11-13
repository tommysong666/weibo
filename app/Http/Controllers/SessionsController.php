<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 登陆会话控制器
 * Class SessionsController
 * @package App\Http\Controllers
 */
class SessionsController extends Controller
{

    //
    /**
     * SessionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    /**
     * 登陆视图
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 登陆实现
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $credentials=$this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);
        if(Auth::attempt($credentials,$request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success','欢迎回来');
                $default=route('users.show',Auth::user());
                return redirect()->intended($default);
            }
            Auth::logout();
            session()->flash('warning','账号尚未激活，请检查注册邮箱并激活');
            return redirect('/');

        }else{
            session()->flash('danger','用户名或密码错误');
            return redirect()->back()->withInput();
        }
    }

    /**
     * 退出登陆
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出！');
        return redirect('login');
    }
}
