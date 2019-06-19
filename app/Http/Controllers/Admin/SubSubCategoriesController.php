<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubSubCategories\CreateRequest;
use App\Http\Requests\Admin\SubSubCategories\UpdateRequest;

class SubSubCategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view sub_sub_categories')->only(['index', 'show']);
        $this->middleware('permission:create sub_sub_categories')->only(['create', 'store']);
        $this->middleware('permission:update sub_sub_categories')->only(['edit', 'update', 'visibility', 'active']);
        $this->middleware('permission:delete sub_sub_categories')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub_sub_categories = SubSubCategory::all();
        return view('admin.sub_sub_categories.index', compact('sub_sub_categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_categories = SubCategory::all();
        return view('admin.sub_sub_categories.create', compact('sub_categories'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $sub_sub_category = SubSubCategory::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'sub_category_id' => $request->category,
        ]);
        if ($request->has('image')) {
            $sub_sub_category
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('sub_sub_category.image');
        }
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SubSubCategory $sub_sub_category)
    {
        return view('admin.sub_sub_categories.show', compact('sub_sub_category'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  SubSubCategory  $sub_sub_category
     * @return \Illuminate\Http\Response
     */
    public function edit(SubSubCategory $sub_sub_category)
    {
        $sub_categories = SubCategory::all();
        return view('admin.sub_sub_categories.edit', compact('sub_sub_category', 'sub_categories'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SubSubCategory  $sub_sub_category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, SubSubCategory $sub_sub_category)
    {
        $sub_sub_category->name_en = $request->name_en;
        $sub_sub_category->name_ar = $request->name_ar;
        $sub_sub_category->description_en = $request->description_en;
        $sub_sub_category->description_ar = $request->description_ar;
        $sub_sub_category->sub_category_id = $request->category;
        $sub_sub_category->save();
        if ($request->has('image')) {
            $sub_sub_category
                ->addMediaFromUrl($request->image)
                ->toMediaCollection('sub_sub_category.image');
        }
        return redirect()->route('sub_sub_categories.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->sub_sub_categories) {
            return back();
        }
        $this->validate($request, [
            'sub_sub_categories.*' => 'required|exists:sub_sub_categories,id',
        ]);
        SubSubCategory::destroy($request->sub_sub_categories);
        return back()->with('status', trans('Deleted Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SubSubCategory  $sub_sub_category
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, SubSubCategory $sub_sub_category)
    {
        $sub_sub_category->active = !($sub_sub_category->active);
        $sub_sub_category->save();
        return redirect()->route('sub_sub_categories.index')->with('status', trans('Updated Successfully'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SubSubCategory  $sub_sub_category
     * @return \Illuminate\Http\Response
     */
    public function visibility(Request $request, SubSubCategory $sub_sub_category)
    {
        $sub_sub_category->navbar_visibility = !($sub_sub_category->navbar_visibility);
        $sub_sub_category->save();
        return redirect()->route('sub_sub_categories.index')->with('status', trans('Updated Successfully'));
    }
}
