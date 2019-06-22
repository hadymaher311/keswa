<?php

namespace App\Models;

use App\Models\SubCategory;
use App\Helpers\LocalizableModel;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Category extends LocalizableModel implements HasMedia
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
        return $this->getMedia('category.image')->last();
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
     * Get all sub categories
     * 
     */
    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
