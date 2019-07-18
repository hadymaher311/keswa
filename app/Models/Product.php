<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Feature;
use App\Models\Discount;
use App\Models\warehouse;
use App\Models\GeneralSetting;
use App\Models\SubSubCategory;
use App\Models\WarehouseProduct;
use App\Helpers\LocalizableModel;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends LocalizableModel implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en', 'name_ar',
        'description_en', 'description_ar',
        'short_description_en', 'short_description_ar',
        'sale_by', 'quantity', 'low_quantity', 'quantity_per_packet', 'min_sale_quantity',
        'length', 'width', 'depth', 'weight',
        'cost', 'price',
        'expiry_date', 'expiry_alarm_before', 'brand_id', 'warehouse_id',
        'upc',
        'sku',
    ];
 
    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
        'description',
        'short_description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiry_date' => 'datetime',
        'active' => 'boolean',
        'free_shipping' => 'boolean',
        'allow_review' => 'boolean',
        'allow_points' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'rating', 'discount_percentage', 'name'
    ];

    /**
     * The function to return Image url.
     *
     */
    public function getImagesAttribute()
    {
        return $this->getMedia('product.images');
    }
    
    
    /**
     * The function to return points.
     *
     */
    public function getPointsAttribute()
    {
        return ($this->allow_points) ? GeneralSetting::pointsValue()->first()->value * $this->final_price : 0;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     */
    public function getSlugAttribute()
    {
        return str_replace(' ', '-', $this->name);
    }
    
    /**
     * Return the english sluggable configuration array for this model.
     *
     */
    public function getSlugEnAttribute()
    {
        return str_replace(' ', '-', $this->name_en);
    }
    
    /**
     * Return the arabic sluggable configuration array for this model.
     *
     */
    public function getSlugArAttribute()
    {
        return str_replace(' ', '-', $this->name_ar);
    }
    
    /**
     * check if true slug.
     *
     */
    public function isTrueSlug($slug)
    {
        return ($this->slug == $slug or $this->slug_en == $slug or $this->slug_ar == $slug);
    }
    
    /**
     * The function to return product rating.
     *
     */
    public function getRatingAttribute()
    {
        return ($this->approvedReviews->count()) ? $this->approvedReviews->sum(function($review) {
            return $review->rate;
          }) / $this->approvedReviews->count() : 0;
    }
    
    /**
     * The function to return product final price after discount.
     *
     */
    public function getFinalPriceAttribute()
    {
        if ($this->activeDiscount) {
            if ($this->activeDiscount->type == 'value') {
                return $this->price - $this->activeDiscount->amount;
            } else {
                return ceil($this->price * (100 - $this->activeDiscount->amount) / 100);
            }
        }
        return $this->price;
        // return ceil($this->price - ($this->price * ($this->discount_percentage / 100)));
    }
    
    // /**
    //  * The function to return product total quantities.
    //  *
    //  */
    // public function getTotalQuantityAttribute()
    // {
    //     return ($this->quantities->count()) ? $this->quantities->sum(function($quantity) {
    //         return $quantity->reduced_quantity;
    //     }) : 0;
    // }
    
    /**
     * The function to return product in specific warehouse quantity.
     *
     */
    public function getWarehouseQuantity($warehouse_id)
    {
        return ($this->quantities->where('warehouse_id', $warehouse_id)->count()) ? $this->quantities->where('warehouse_id', $warehouse_id)->sum(function($quantity) {
            return $quantity->reduced_quantity;
        }) : 0;
    }
    
    /**
     * The function to return product discount percentage.
     *
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->activeDiscount) {
            if ($this->activeDiscount->type == 'value') {
                return ceil(($this->activeDiscount->amount / $this->price) * 100);
            } else {
                return $this->activeDiscount->amount;
            }
        }
        return 0;
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('card')
              ->width(368)
              ->height(232);
        $this->addMediaConversion('thumb')
              ->width(100)
              ->height(100);
    }

    /**
     * Get product categories
     * 
     */
    public function categories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'product_categories', 'product_id', 'sub_sub_category_id')->withTimestamps();
    }
    
    /**
     * Get product active categories
     * 
     */
    public function active_categories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'product_categories', 'product_id', 'sub_sub_category_id')->withTimestamps()->active();
    }
    
    /**
     * Get product features
     * 
     */
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'product_features', 'product_id', 'feature_id')->withTimestamps();
    }
    
    /**
     * Get related products
     * 
     */
    public function related_products()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id')->withTimestamps();
    }
    
    /**
     * Get product accessories
     * 
     */
    public function accessories()
    {
        return $this->belongsToMany(Product::class, 'product_accessories', 'product_id', 'accessory_id')->withTimestamps();
    }
    
    /**
     * Get active related products
     * 
     */
    public function active_related_products()
    {
        return $this->related_products()->active();
    }
    
    /**
     * Get active product accessories
     * 
     */
    public function active_accessories()
    {
        return $this->accessories()->active();
    }
    
    /**
     * Get product Tags
     * 
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    
    /**
     * Get product discount
     * 
     */
    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
    
    /**
     * Get product brand
     * 
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    /**
     * Get product warehouse
     * 
     */
    public function warehouses()
    {
        return $this->belongsToMany(warehouse::class, 'warehouse_products');
    }
    
    /**
     * Get product distinct warehouse
     * 
     */
    public function distinct_warehouses()
    {
        return $this->belongsToMany(warehouse::class, 'warehouse_products')->distinct();
    }
    
    /**
     * Get product reviews
     * 
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get product quantities
     * 
     */
    public function quantities()
    {
        return $this->hasMany(WarehouseProduct::class);
    }
    
    /**
     * Get product approved reviews
     * 
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->approved();
    }
    
    /**
     * Get product active discount
     * 
     */
    public function activeDiscount()
    {
        return $this->hasOne(Discount::class)->active();
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {;
        return $query->where('active', 1)->whereHas('active_categories')->available();
    }
    
    /**
     * Scope a query to only include available products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereColumn('total_quantity', '>=', 'min_sale_quantity');
    }
    
    /**
     * if product is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return ($this->total_quantity >= $this->min_sale_quantity);
    }
}