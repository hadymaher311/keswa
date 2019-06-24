<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
