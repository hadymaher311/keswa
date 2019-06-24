<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
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
}
