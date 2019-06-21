<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Brand;
use App\Models\Feature;
use App\Models\Product;
use App\Models\warehouse;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\CreateRequest;

class ProductsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:view products')->only(['index', 'show']);
        $this->middleware('permission:create products')->only(['create', 'store']);
        $this->middleware('permission:update products')->only(['edit', 'update']);
        $this->middleware('permission:delete products')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_sub_categories = SubSubCategory::all();
        $warehouses = warehouse::all();
        $products = Product::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('sub_sub_categories', 'warehouses', 'products', 'brands'));
    }
    
    /**
     * Store product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Product
     */
    protected function storeProduct(Request $request)
    {
        return Product::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'short_description_en' => $request->short_description_en,
            'short_description_ar' => $request->short_description_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'expiry_date' => Carbon::create($request->expiry_date),
            'SKU' => $request->sku,
            'quantity' => $request->quantity,
            'low_quantity' => $request->low_quantity,
            'quantity_per_packet' => $request->quantity_per_packet,
            'min_sale_quantity' => $request->min_sale_quantity,
            'price' => $request->price,
            'cost' => $request->cost,
            'length' => $request->length,
            'width' => $request->width,
            'depth' => $request->depth,
            'weight' => $request->weight,
            'brand_id' => $request->brand,
        ]);
    }

    /**
     * Store product Images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Http\Product
     */
    protected function storeProductImages(Product $product, Request $request)
    {
        foreach ($request->images as $image) {
            $product
                ->addMediaFromBase64($image)
                ->toMediaCollection('product.images');
        }
    }
    
    /**
     * Store product Features.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Http\Product
     */
    protected function storeProductFeatures(Product $product, Request $request)
    {
        if ($request->feature_type) {
            $data = [];
            for ($i=0; $i < count($request->feature_type); $i++) { 
                $data[] = [
                    'name_en' => $request->feature_type[$i],
                    'value_en' => $request->feature_value[$i],
                ];
            }
            $features = Feature::create($data);
    
            $product->features()->sync($features);
        }
    }
    
    /**
     * Store product Tags.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Http\Product
     */
    protected function storeProductTags(Product $product, Request $request)
    {
        if ($request->tags) {
            $tags = explode(',', $request->tags);
            foreach ($tags as $tag) {
                Tag::create([
                    'name' => $tag,
                    'product_id' => $product->id,
                ]); 
            }
        }
    }
    
    /**
     * Store product Accessories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Http\Product
     */
    protected function storeProductAccessories(Product $product, Request $request)
    {
        if ($request->accessories) {
            $product->accessories()->sync($request->accessories);
        }
    }
    
    /**
     * Store product RelatedProducts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Http\Product
     */
    protected function storeRelatedProducts(Product $product, Request $request)
    {
        if ($request->related_product) {
            $product->related_products()->sync($request->related_product);
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
        $product = $this->storeProduct($request);
        // sync with categories
        $product->categories()->sync($request->categories);
        $this->storeProductImages($product, $request);
        $this->storeProductFeatures($product, $request);
        $this->storeProductTags($product, $request);
        
        // store related products and accessories
        $this->storeRelatedProducts($product, $request);
        $this->storeProductAccessories($product, $request);
        
        return back()->with(['status' => trans('Added Successfully')]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // $sub_categories = SubCategory::all();
        // return view('admin.products.edit', compact('product', 'sub_categories'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product)
    {
        // $product->name_en = $request->name_en;
        // $product->name_ar = $request->name_ar;
        // $product->description_en = $request->description_en;
        // $product->description_ar = $request->description_ar;
        // $product->sub_category_id = $request->category;
        // $product->save();
        // if ($request->has('image')) {
        //     $product
        //         ->addMediaFromUrl($request->image)
        //         ->toMediaCollection('product.images');
        // }
        // return redirect()->route('products.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->products) {
            return back();
        }
        $this->validate($request, [
            'products.*' => 'required|exists:products,id',
        ]);
        Product::destroy($request->products);
        return back()->with('status', trans('Deleted Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function active(Request $request, Product $product)
    {
        $product->active = !($product->active);
        $product->save();
        return redirect()->route('products.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function allowReviews(Request $request, Product $product)
    {
        $product->allow_review = !($product->allow_review);
        $product->save();
        return redirect()->route('products.index')->with('status', trans('Updated Successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function freeShipping(Request $request, Product $product)
    {
        $product->free_shipping = !($product->free_shipping);
        $product->save();
        return redirect()->route('products.index')->with('status', trans('Updated Successfully'));
    }
}
