<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'category_id'];

    /**
     * Public URL for the product image.
     * New/migrated images store the full Cloudinary secure URL in `image`, so no API
     * call is needed to render them. Legacy relative paths ("products/x.jpg") still
     * resolve to the local public disk for old local data.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            $image = $this->image;

            if (! $image) {
                return null;
            }

            return preg_match('#^https?://#i', $image) ? $image : asset('storage/'.ltrim($image, '/'));
        });
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items', 'product_id', 'order_id');
    }
}
