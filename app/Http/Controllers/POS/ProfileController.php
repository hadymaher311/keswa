<?php

namespace App\Http\Controllers\POS;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\POSWorkerSetting;
use App\Models\POSWorkerAddress;
use App\Models\POSWorkerPersonalInfo;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:pos');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pos.profile.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('pos.profile.edit');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->ValidateUpdateRequest($request);
        auth()->user()->first_name = $request->first_name;
        auth()->user()->last_name = $request->last_name;
        auth()->user()->email = $request->email;
        auth()->user()->save();
        $request['worker_id'] = auth()->id();
        POSWorkerPersonalInfo::updateOrCreate(
            ['worker_id' => auth()->id()],
            $request->all()
        );
        return redirect()->route('pos.profile')->with('status', trans('Updated Successfully'));
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
                Rule::unique('p_o_s_workers')->ignore(auth()->id())
            ],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:11', 'min:11'],
            'gender' => ['required', 'string', 'in:male,female'],
        ]);
    }
    
    /**
     * Show the form for editing worker password.
     *
     * @return \Illuminate\Http\Response
     */
    public function editPassword()
    {
        return view('pos.profile.editpassword');
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
        return redirect()->route('pos.profile')->with('status', trans('Updated Successfully'));
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
            foreach (auth()->user()->getMedia('pos_worker.avatar') as $image) {
                $image->delete();
            }
            auth()->user()
                ->addMediaFromBase64($request->image)
                ->toMediaCollection('pos_worker.avatar');
        return redirect()->route('pos.profile')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Show the settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSettings()
    {
        return view('pos.profile.settings');
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
            $settings = new POSWorkerSetting;
            $settings->language = $request->language;
            $settings->worker_id = auth()->id();
        }
        $settings->save();
        return redirect($settings->language.'/pos/profile')->with('status', trans('Updated Successfully'));
    }

    /**
     * Show the form for editing worker address.
     *
     * @return \Illuminate\Http\Response
     */
    public function editAddress()
    {
        return view('pos.profile.editAddress');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(Request $request)
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
        $request['worker_id'] = auth()->id();
        POSWorkerAddress::updateOrCreate(
            ['worker_id' => auth()->id()],
            $request->all()
        );
        return redirect()->route('pos.profile')->with('status', trans('Updated Successfully'));
    }
}
