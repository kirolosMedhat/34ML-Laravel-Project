<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'values'];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
