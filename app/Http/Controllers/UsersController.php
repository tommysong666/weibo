<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * 用户注册类
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['create','show','store','index','activated']
        ]);
        $this->middleware('guest',['only'=>['create']]);
    }

    /**
     * 用户注册视图
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 用户个人中心
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    /**
     * 用户注册实现
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|min:3|max:50',
            'email'=>'required|unique:users|email|max:255',
            'password'=>'required|confirmed|min:6',
        ]);
        $user=User::create([
            'name'=>$request->name,
            'password'=>bcrypt($request->password),
            'email'=>$request->email
        ]);
        $this->sendEmailConfirmationTo($user);//发送注册邮箱
        session()->flash('success','激活链接已发送邮箱，请查收并激活后尝试登陆！');
        return redirect('/');
    }

    /**
     * 用户编辑视图
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /**
     * 用户编辑实现
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update',$user);
        $this->validate($request,[
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:6'
        ]);
        $data=[];
        $data['name']=$request->name;
        if($request->password){
            $data['password']=bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','更新成功');
        return redirect()->route('users.show',$user);
    }

    /**
     * 用户列表
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users=User::orderBy('id')->paginate(10);
        return view('users.index',compact('users'));
    }

    /**
     * 用户删除
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','删除成功！');
        return back();
    }

    public function sendEmailConfirmationTo($user)
    {
        $view='emails.activation_email';
        $data=compact('user');
        /*$from='tommy@example.com';
        $from_name='tommy';*/
        $to=$user->email;
        $subject='感谢注册微博网，请确认你的邮箱！';
        Mail::send($view,$data,function ($mailInfo) use ($to,$subject){
            //$mailInfo->from($from,$from_name)->to($to)->subject($subject);
            $mailInfo->to($to)->subject($subject);
        });
    }

    public function activated($token)
    {
        $user=User::where('activation_token',$token)->firstOrFail();
        $user->activated=true;
        $user->activation_token=null;
        $user->email_verified_at=now();
        $user->save();
        Auth::login($user);
        session()->flash('success','恭喜激活成功，开启新旅程！');
        return redirect()->route('users.show',$user);
    }
}
