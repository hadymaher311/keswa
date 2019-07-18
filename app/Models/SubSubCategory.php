<?php

namespace App\Models;

use App\Models\Product;
use App\Models\SubCategory;
use App\Helpers\LocalizableModel;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SubSubCategory  extends LocalizableModel implements HasMedia
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
        'sub_category_id'
    ];
 
    /**
     * Localized attributes.
     *
     * @var array
     */
    protected $localizable = [
        'name',
        'description'
    ];

    /**
     * The function to return Image url.
     *
     */
    public function getImageAttribute()
    {
        return $this->getMedia('sub_category.image')->last();
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
     * Get sub category
     * 
     */
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    
    /**
     * Get active sub category
     * 
     */
    public function active_sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id')->active();
    }
    
    /**
     * Get products
     * 
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'sub_sub_category_id', 'product_id')->withTimestamps();
    }
    
    /**
     * Get latest products
     * 
     */
    public function latestProducts()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'sub_sub_category_id', 'product_id')->active()->orderBy('created_at', 'desc')->take(7)->withTimestamps();
    }

    /**
     * Scope a query to only include active sub sub categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1)->whereHas('active_sub_category');
    }
}
