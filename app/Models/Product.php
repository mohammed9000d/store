<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'category_id', 'description', 'image', 'status',
        'price', 'sale_price', 'quantitiy', 'sku', 'weight', 'width', 'height', 'length'];

    public static function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|int|min:0',
            'sku' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'status' => 'in:Active,Draft'
        ];
    }

    public function getImageUrlAttribute() {
        if(!$this->image) {
            return asset('images/placeholder.png');
        }

        if(stripos($this->image, 'http') === 0) {
            return $this->image;
        }

        return asset('uploads' . $this->image);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = Str::title($value);
        $this->attributes['slug'] = Str::slug($value);
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault(['name' => 'No Category']);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(['name' => 'No User']);
    }

    public function ratings() {
        return $this->morphMany(Rating::class, 'rateable', 'rateable_type', 'rateable_id', 'id');
    }
}
