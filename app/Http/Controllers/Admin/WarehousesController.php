<?php

namespace App\Http\Controllers\Admin;

use App\Models\warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Warehouses\CreateRequest;
use App\Http\Requests\Admin\Warehouses\UpdateRequest;

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
        $this->middleware('permission:view warehouses')->only(['index', 'show']);
        $this->middleware('permission:create warehouses')->only(['create', 'store']);
        $this->middleware('permission:update warehouses')->only(['edit', 'update']);
        $this->middleware('permission:delete warehouses')->only(['destroy']);
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
     * Store warehouse related locations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\warehouse  $warehouse
     */
    protected function storeRelatedLocations(Request $request, $warehouse)
    {
        $related_locations = explode(',', $request->related_locations);
        foreach ($related_locations as $location) {
            $warehouse->related_locations()->create(['location_name' => $location]); 
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $warehouse = warehouse::create([
            'name_en' => $request->name,
            'name_ar' => $request->name_ar,
            'location_en' => $request->location,
            'location_ar' => $request->location_ar,
            'shipping_price' => $request->shipping_price,
        ]);
        $this->storeRelatedLocations($request, $warehouse);
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(warehouse $warehouse)
    {
        return view('admin.warehouses.show', compact('warehouse'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    /**
     * Update warehouse related locations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\warehouse  $warehouse
     */
    protected function updateRelatedLocations(Request $request, $warehouse)
    {
        $warehouse->related_locations()->delete();
        $related_locations = explode(',', $request->related_locations);
        foreach ($related_locations as $location) {
            $warehouse->related_locations()->create(['location_name' => $location]); 
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, warehouse $warehouse)
    {
        $warehouse->name_en = $request->name;
        $warehouse->name_ar = $request->name_ar;
        $warehouse->location_en = $request->location;
        $warehouse->location_ar = $request->location_ar;
        $warehouse->shipping_price = $request->shipping_price;
        $warehouse->save();
        $this->updateRelatedLocations($request, $warehouse);
        return redirect()->route('warehouses.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  warehouse  $warehouse
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, warehouse $warehouse)
    {
        $warehouse->active = !($warehouse->active);
        $warehouse->save();
        return back()->with('status', trans('Updated Successfully'));
    }
}
