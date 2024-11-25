<?php

namespace App\Models;

use App\Entities\ProductEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductEntity::class);
    }
}
