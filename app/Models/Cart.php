<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'cookie_id', 'product_id', 'user_id', 'quantity'
    ];
    protected $with = ['product'];


    protected static function booted()
    {
        /*
         Events:
        creating, created, updating, updated, saving, saved
        deleting, deleted, restoring, restored
        */
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
