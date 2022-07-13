<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'parent_id', 'description', 'image', 'status'];

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function children(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault(['name' => 'No Parent']);
    }
    // Exists Attribute
    // $model->name
    public function getNameAttribute($value)
    {
        if($this->trashed()) {
            return $value. '(Deleted)';
        }
        return $value;
    }
    // Exists Attribute
    // $model->original_name
    public function getOriginalNameAttribute() {
        return $this->attributes['name'];
    }

}
