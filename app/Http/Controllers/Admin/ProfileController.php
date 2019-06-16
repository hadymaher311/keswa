<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminSetting;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.profile.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.profile.edit');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request->all();
        $this->ValidateUpdateRequest($request);
        auth()->user()->first_name = $request->first_name;
        auth()->user()->last_name = $request->last_name;
        auth()->user()->email = $request->email;
        auth()->user()->save();
        return redirect()->route('admin.profile')->with('status', trans('Updated Successfully'));
    }

    /**
     * Valudate Update Registe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function validateUpdateRequest(Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                        Rule::unique('admins')->ignore(auth()->id())
                        ],
        ]);
    }
    
    /**
     * Show the form for editing admin password.
     *
     * @return \Illuminate\Http\Response
     */
    public function editPassword()
    {
        return view('admin.profile.editpassword');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            auth()->user()->password = Hash::make($request->password);
        auth()->user()->save();
        return redirect()->route('admin.profile')->with('status', trans('Updated Successfully'));
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
            foreach (auth()->user()->getMedia('admin.avatar') as $image) {
                $image->delete();
            }
            auth()->user()
                ->addMediaFromBase64($request->image)
                ->toMediaCollection('admin.avatar');
        return redirect()->route('admin.profile')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Show the settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSettings()
    {
        return view('admin.profile.settings');
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateLanguage(Request $request)
    {
        $this->validate($request, [
            'language' => ['required', 'string', 'in:ar,en'],
            ]);
        $settings = auth()->user()->settings;
        if ($settings) {
            $settings->language = $request->language;
        } else {
            $settings = new AdminSetting;
            $settings->language = $request->language;
            $settings->admin_id = auth()->id();
        }
        $settings->save();
        return redirect($settings->language.'/admin/profile')->with('status', trans('Updated Successfully'));
    }
}
