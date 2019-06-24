<?php

namespace App\Http\Controllers\User;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.profile.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateImage(Request $request)
    {
        $this->validate($request, [
        'image' => ['required', 'base64image']
        ]);
        foreach (auth()->user()->getMedia('user.avatar') as $image) {
            $image->delete();
        }
        auth()->user()
            ->addMediaFromBase64($request->image)
            ->toMediaCollection('user.avatar');
        return back()->with('status', trans('Updated Successfully'));
    }

    /**
     * Display user addresses.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAddress()
    {
        return view('user.profile.addressBook');
    }

    /**
     * store user address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAddress(Request $request)
    {
        $this->validate($request, [
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'building' => ['required', 'string', 'max:255'],
            'floor' => ['required', 'string', 'max:255'],
            'apartment' => ['required', 'string', 'max:255'],
            'nearest_landmark' => ['nullable', 'string', 'max:255'],
            'location_type' => ['required', 'string', 'in:home,business'],
        ]);
        auth()->user()->addresses()->create($request->all());
        return back()->with('status', trans('Added Successfully'));
    }
    
    /**
     * Display user edit personal info.
     *
     * @return \Illuminate\Http\Response
     */
    public function editInfo()
    {
        return view('user.profile.infoEdit');
    }

    /**
     * update user personal info in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInfo(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                Rule::unique('users', 'email')->ignore(auth()->user()->id)        
            ],
            // personal info
            'phone' => ['required', 'string', 'max:11', 'min:11'],
            'gender' => ['required', 'string', 'in:male,female'],
        ]);
        auth()->user()->update($request->all());
        auth()->user()->personalInfo->update($request->all());
        return redirect()->route('user.profile')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Display user edit addresses.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAddress(UserAddress $address)
    {
        return view('user.profile.addressEdit', compact('address'));
    }

    /**
     * update user address in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(Request $request, UserAddress $address)
    {
        $this->validate($request, [
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'building' => ['required', 'string', 'max:255'],
            'floor' => ['required', 'string', 'max:255'],
            'apartment' => ['required', 'string', 'max:255'],
            'nearest_landmark' => ['nullable', 'string', 'max:255'],
            'location_type' => ['required', 'string', 'in:home,business'],
        ]);
        $address->update($request->all());
        return redirect()->route('user.addresses')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * update user password in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'old_password' => ['required', 'string', 'min:8'],
        ]);
        if (Hash::check($request->old_password, auth()->user()->password)) {
            auth()->user()->password = Hash::make($request->password);
            auth()->user()->save();
            return redirect()->route('user.addresses')->with('status', trans('Updated Successfully'));
        }
        return back()->with(['password' => trans('Wrong Password')]);
    }
}