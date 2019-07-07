<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;

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
        $price_tax = GeneralSetting::priceTax()->first();
        $working_hours_from = GeneralSetting::workingHoursFrom()->first();
        $working_hours_to = GeneralSetting::workingHoursTo()->first();
        $points_value = GeneralSetting::pointsValue()->first();
        return view('admin.settings.general', compact('price_tax', 'working_hours_from', 'working_hours_to', 'points_value'));
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
    
    /**
     * Store Points Value in database
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storePointsValue(Request $request)
    {
        $this->validate($request, [
            'points_value' => 'required|integer|min:1',
        ]);
        GeneralSetting::updateOrCreate(
            ['name' => 'points_value'],
            ['value' => $request->points_value]
        );
        return back()->with(['status' => trans('Updated Successfully')]);
    }
    
    /**
     * Store Working hours in database
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeWorkingHours(Request $request)
    {
        $request['working_hours_from'] = Carbon::create($request->working_hours_from);
        $request['working_hours_to'] = Carbon::create($request->working_hours_to);

        $this->validate($request, [
            'working_hours_from' => 'required|date|before:working_hours_to',
            'working_hours_to' => 'required|date|after:working_hours_from',
        ]);
        GeneralSetting::updateOrCreate(
            ['name' => 'working_hours_from'],
            ['value' => $request->working_hours_from->format('h:i A')]
        );
        GeneralSetting::updateOrCreate(
            ['name' => 'working_hours_to'],
            ['value' => $request->working_hours_to->format('h:i A')]
        );
        return back()->with(['status' => trans('Updated Successfully')]);
    }
}
