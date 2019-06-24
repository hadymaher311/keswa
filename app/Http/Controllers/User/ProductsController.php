<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;
use TomLingham\Searchy\Facades\Searchy;

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
        $category_products = $category->active()->firstOrFail()->products()->orderBy($sort_list[0], $sort_list[1])->active()->paginate(15);
        if ($category_products) {
            $latest_products = Product::orderBy('created_at', 'desc')->active()->get()->take(5);
            return view('user.products.categoryProducts', compact('searched_category', 'category_products', 'latest_products'));
        }
        abort(404);
    }

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
}
