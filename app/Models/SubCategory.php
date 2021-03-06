<?php

namespace App\Models;

use App\Models\Category;
use App\Models\SubSubCategory;
use App\Helpers\LocalizableModel;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SubCategory  extends LocalizableModel implements HasMedia
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
        'category_id'
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
     * Get main category
     * 
     */
    public function main_category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    /**
     * Get active main category
     * 
     */
    public function active_main_category()
    {
        return $this->belongsTo(Category::class, 'category_id')->active();
    }
    
    /**
     * Get sub sub category
     * 
     */
    public function sub_sub_categories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1)->whereHas('active_main_category');
    }
}
