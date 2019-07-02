<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;

class GeneralSettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:general settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $price_tax = GeneralSetting::priceTax();
        return view('admin.settings.general', compact('price_tax'));
    }

    /**
     * Store Price Tax in database
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storePriceTax(Request $request)
    {
        $this->validate($request, [
            'price_tax' => 'required|integer|min:0',
        ]);
        GeneralSetting::updateOrCreate(
            ['name' => 'price_tax'],
            ['value' => $request->price_tax]
        );
        return back()->with(['status' => trans('Updated Successfully')]);
    }
}
