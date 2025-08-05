<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'category_id'];

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
