<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function edit()
    {
        $user = Auth::user();

        return view('admin.profile.edit' , [
            'user' =>  $user,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name'  => ['required' , 'string' , 'max:255'],
            'birthday'   => ['nullable' , 'date' , 'before:today'],
            'gender'     => ['in:male,female'],
            'country'    => ['required' , 'string' , 'size:2']
        ]);

        $user = $request->user();

        $user->profile->fill($request->all())->save();

        return redirect()->route('admin.profile.edit')->with('success' , 'Profile update!');
        
        // $user = $request->user();

        // $profile  = $user->profile;

        // if($profile->user_id){
        //     $profile->update($request->all());
        // }else {
        //     $request->merge([
        //         'user_id' => $user->id,
        //     ]);
        //     Profile::create($request->all());
        // }

       // $user->profile->update($request->all());
    }
}
