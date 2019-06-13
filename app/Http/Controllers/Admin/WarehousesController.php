<?php

namespace App\Http\Controllers\Admin;

use App\Models\warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Warehouses\CreateRequest;

class WarehousesController extends Controller
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
        $warehouses = warehouse::all();
        return view('admin.warehouses.index', compact('warehouses'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        warehouse::create([
            'name_en' => $request->name,
            'name_ar' => $request->name_ar,
            'location_en' => $request->location,
            'location_ar' => $request->location_ar,
        ]);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(warehouse $warehous)
    {
        return view('admin.warehouses.show', compact('warehouse'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  warehouse  $warehous
     * @return \Illuminate\Http\Response
     */
    public function edit(warehouse $warehous)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  warehouse  $warehous
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, warehouse $warehous)
    {
        $this->validate($request, [
            'name' => 'required|string|min:2'
        ]);
        $warehous->name = $request->name;
        $warehous->save();
        return redirect()->route('warehouses.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  warehouse  $warehous
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->warehouses) {
            return back();
        }
        $this->validate($request, [
            'warehouses.*' => 'required|exists:warehouses,id',
        ]);
        warehouse::destroy($request->warehouses);
        return back()->with('status', trans('Deleted Successfully'));
    }
}
