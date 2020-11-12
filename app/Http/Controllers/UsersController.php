<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
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
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
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

}
