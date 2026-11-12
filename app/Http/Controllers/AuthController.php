<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //registerページに関する記述

    public function register()
    {
        return view('register');
    }

    public function register_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:3',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $existEmail = User::where('email', $request->input('email'))->exists();
        if ($existEmail) {
            session()->flash('warning', 'Email Already Token!');

            return redirect()->back();
        }

        if ($request->input('password') !== $request->input('password_confirmation')) {
            session()->flash('warning', 'Confirm Password Not Matched!');

            return redirect()->back();
        }

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploaded_files/'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        session()->flash('success', 'Registered Successfully!');

        return redirect()->route('user.login');
    }

    //loginページに関する記述

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $request->session()->regenerate();

            return redirect()->route('user.all_posts');
        } else {
            session()->flash('warning', 'Email Or Password Incorrect!');
            return redirect()->back();
        }
    }

    //logout処理に関する記述

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
