<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brands\CreateRequest;
use App\Http\Requests\Admin\Brands\UpdateRequest;

class BrandsController extends Controller
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
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SubCategory::all();
        return view('admin.brands.create', compact('categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $brand = Brand::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'category_id' => $request->category,
        ]);
        if ($request->has('image')) {
            $brand
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('brand.image');
        }
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        return view('admin.brands.show', compact('brand'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        $categories = SubCategory::all();
        return view('admin.brands.edit', compact('brand', 'categories'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Brand $brand)
    {
        $brand->name_en = $request->name_en;
        $brand->name_ar = $request->name_ar;
        $brand->description_en = $request->description_en;
        $brand->description_ar = $request->description_ar;
        $brand->save();
        if ($request->has('image')) {
            $brand
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('brand.image');
        }
        return redirect()->route('brands.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->brands) {
            return back();
        }
        $this->validate($request, [
            'brands.*' => 'required|exists:brands,id',
        ]);
        Brand::destroy($request->brands);
        return back()->with('status', trans('Deleted Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, Brand $brand)
    {
        $brand->active = !($brand->active);
        $brand->save();
        return redirect()->route('brands.index')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function visibility(Request $request, Brand $brand)
    {
        $brand->navbar_visibility = !($brand->navbar_visibility);
        $brand->save();
        return redirect()->route('brands.index')->with('status', trans('Updated Successfully'));
    }
}
