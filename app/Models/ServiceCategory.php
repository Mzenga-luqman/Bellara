<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'order',
    ];

    protected static function booted(): void
    {
        static::creating(function (ServiceCategory $category) {
            if (empty($category->slug)) {
                $category->slug = static::buildUniqueSlug($category->name);
            }
        });

        static::updating(function (ServiceCategory $category) {
            if ($category->isDirty('name')) {
                $category->slug = static::buildUniqueSlug($category->name, $category->id);
            }
        });
    }

    protected static function buildUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug !== '' ? $baseSlug : 'category';
        $suffix = 1;

        while (static::query()
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'category_id')->where('is_active', true);
    }

    public function staffMembers(): HasMany
    {
        return $this->hasMany(Staff::class, 'service_category_id')->where('is_active', true);
    }
}
