<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','slug','sku','description','price','cost_price','active','meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function getActiveDiscountAttribute()
    {
        $now = now();
        return $this->discounts()->where(function($q) use ($now){
            $q->whereNull('starts_at')->orWhere('starts_at','<=',$now);
        })->where(function($q) use ($now){
            $q->whereNull('ends_at')->orWhere('ends_at','>=',$now);
        })->latest()->first();
    }

    public function getFinalPriceAttribute()
    {
        $price = (float)$this->price;
        $discount = $this->active_discount;
        if (! $discount) return $price;

        if ($discount->type === 'percentage') {
            return round($price - ($price * ($discount->value / 100)), 2);
        }

        return round(max(0, $price - $discount->value), 2);
    }
}
