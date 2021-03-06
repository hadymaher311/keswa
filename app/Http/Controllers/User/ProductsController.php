<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;
use TomLingham\Searchy\Facades\Searchy;
use App\Models\Brand;

class ProductsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $slug)
    {
        if ($product->isTrueSlug($slug) and $product->active) {
            $latest_products = Product::orderBy('created_at', 'desc')->active()->get()->take(5);
            return view('user.products.show', compact('product', 'latest_products'));
        }
        abort(404);
    }
    
    /**
     * Display the products with category.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  App\Models\SubSubCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function category(Request $request, SubSubCategory $category)
    {
        $this->validate($request, [
            'sort' => 'nullable|string|in:created_at-asc,name_en-asc,name_en-desc,name_ar-asc,name_ar-desc,price-asc,price-desc'
        ]);
        $sort_list = ['created_at', 'desc'];
        if ($request->sort) {
            $sort_list = explode('-', $request->sort);
        }
        $searched_category = $category;
        $category_products = $category->products()->orderBy($sort_list[0], $sort_list[1])->active()->paginate(15);
        if ($category_products) {
            $latest_products = Product::orderBy('created_at', 'desc')->active()->get()->take(5);
            return view('user.products.categoryProducts', compact('searched_category', 'category_products', 'latest_products'));
        }
        abort(404);
    }
    
    /**
     * Display the products with brand.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  App\Models\Brand  $category
     * @return \Illuminate\Http\Response
     */
    public function brand(Request $request, Brand $brand)
    {
        $this->validate($request, [
            'sort' => 'nullable|string|in:created_at-asc,name_en-asc,name_en-desc,name_ar-asc,name_ar-desc,price-asc,price-desc'
        ]);
        $sort_list = ['created_at', 'desc'];
        if ($request->sort) {
            $sort_list = explode('-', $request->sort);
        }
        $searched_brand = $brand;
        $brand_products = $brand->products()->orderBy($sort_list[0], $sort_list[1])->active()->paginate(15);
        if ($brand_products) {
            $latest_products = Product::orderBy('created_at', 'desc')->active()->get()->take(5);
            return view('user.products.brandProducts', compact('searched_brand', 'brand_products', 'latest_products'));
        }
        abort(404);
    }

    /**
     * Display the products in the search.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'term' => 'required|string',
            'category_id' => 'required|integer|min:0',
        ]);
        $searchResults = Product::hydrate(Searchy::products([
            'name_en', 'name_ar',
            'description_en', 'description_ar',
            'short_description_en', 'short_description_ar',
        ])->query($request->term)->get()->toArray())->where('active', 1);
        $category = SubSubCategory::find($request->category_id);
        $latest_products = Product::orderBy('created_at', 'desc')->active()->get()->take(5);
        if ($category) {
            $category_products = $category->active()->first()->products()->active()->get();
            $searchResults = $searchResults->intersect($category_products);
        }
        return view('user.products.search', compact('searchResults', 'latest_products'));
    }

    /**
     * Store Product review.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function storeReview(Request $request, Product $product)
    {
        $this->validate($request, [
            'content' => 'required|string',
            'rate' => 'required|integer|min:1|max:5'
        ]);
        $request['content'] = str_replace('<', '&lt;', $request->content);
        $request['content'] = str_replace('>', '&gt;', $request->content);
        $request['content'] = nl2br($request->content);
        $request['user_id'] = auth()->id();
        $product->reviews()->create($request->all());
        return back()->with('status', trans('Added Successfully'));        
    }
}
