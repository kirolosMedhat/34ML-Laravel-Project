<?php

namespace App\Models;

use App\Events\ProductOutOfStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use Notifiable;
    protected $fillable = ['title', 'is_in_stock', 'average_rating'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
