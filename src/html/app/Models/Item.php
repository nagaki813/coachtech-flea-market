<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'brand_name',
        'description',
        'price',
        'condition',
        'image_path',
        'is_sold',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function getConditionLabelAttribute(): string
    {
        return [
            1 => '良好',
            2 => '目立った傷や汚れ無し',
            3 => 'やや傷や汚れあり',
            4 => '状態が悪い',
        ][$this->condition] ?? '';
    }
}