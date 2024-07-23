<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
     protected $fillable = ['status'];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
