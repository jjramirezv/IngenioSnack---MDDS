<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'target_product_id', 'required_quantity', 'reward_product_id', 'is_active'];

    public function targetProduct()
    {
        return $this->belongsTo(Product::class, 'target_product_id');
    }

    public function rewardProduct()
    {
        return $this->belongsTo(Product::class, 'reward_product_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('progress')->withTimestamps();
    }
}