<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function photo(): Attribute
    {
        return Attribute::make(
            get: function ($value){
                if(str_contains($value ,'/storage' ))
                {
                    return env('APP_URL') .$value;
                } else{
                    return $value;
                }
            });
    }

    public function scopeFilter($query ,$filters)
    {
        if(isset($filters['category']))
        {
            $query->whereHas('category' , function ($catQuery) use ($filters) {
                $catQuery->where('name', $filters['category']);
            });
        }
    }
}
