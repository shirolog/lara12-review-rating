<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //edit_profileページに関する記述

    public function edit_profile(User $user)
    {
        if ($user->id !== Auth::id()) {
            abort(403);
        }

        return view('edit_profile', compact('user'));
    }

    public function profile_update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'old_password' => 'nullable',
            'new_password' => 'nullable|confirmed|min:3',
            'new_password_confirmation' => 'nullable',
            'image' => 'image|nullable',
        ]);

        $existEmail = User::where('email', $request->input('email'))->where('id', '!=', $user->id)->exists();
        if ($existEmail) {
            session()->flash('warning', 'Email already token!');

            return redirect()->back();
        }

        if ($validator->fails()) {
            if ($validator->errors()->has('new_password')) {
                session()->flash('error', 'Confirm Password Not Matched!');
            }

            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        if ($request->filled('email')) {
            $user->email = $request->input('email');
        }

        if ($request->filled('old_password')) {
            if (!Hash::check($request->input('old_password'), $user->password)) {
                session()->flash('error', 'Old Password Does Not Match.');
                return redirect()->back();
            }
            $user->password = Hash::make($request->input('new_password'));
        }

        if ($request->hasFile('image')) {
            $oldImage = public_path('uploaded_files/' . $user->image);

            if (is_file($oldImage)) {
                unlink($oldImage);
            }

            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploaded_files/'), $imageName);
            $user->image = $imageName;
        }
        $user->save();

        session()->flash('success', 'Profile Updated Successfully!');

        return redirect()->back();
    }

    public function profile_img_destroy(User $user)
    {
        if ($user->image) {
            $oldImage = public_path('uploaded_files/' . $user->image);

            if (is_file($oldImage)) {
                unlink($oldImage);
                $user->image = null;
                $user->save();
            }
        }

        session()->flash('success', 'Image Deleted Successfully!');

        return response()->json([
            'status' => true,
        ]);
    }
}
