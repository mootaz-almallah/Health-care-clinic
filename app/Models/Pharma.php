<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pharma extends Model
{
    use HasFactory;
    protected $table = 'pharma';
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'quantity',
        'image'
    ];

    /**
     * Get the category that owns the pharma.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the pharma.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return null;
    }
} 