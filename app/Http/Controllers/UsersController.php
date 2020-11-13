<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    //
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['create','show','store','index']
        ]);
        $this->middleware('guest',['only'=>['create']]);
    }

    public function create()
    {
        return view('users.create');
    }
    public function show(User $user){
        return view('users.show',compact('user'));
    }

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
        Auth::login($user);
        session()->flash('success','注册成功，开启新旅程');
        return redirect()->route('users.show',$user);
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
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

    public function index()
    {
        $users=User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','删除成功！');
        return back();
    }
}
