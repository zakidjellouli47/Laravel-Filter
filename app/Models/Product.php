<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use http\Exception\RuntimeException;

class Product extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'description', 'status', 'category_id',
    ];

    /**
     * Define the relationships.
     */

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the likes for the product.
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the reviews for the product.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Define scopes for filtering and sorting.
     */

    /**
     * Scope a query to apply filters.
     *
     * @param Builder $query
     * @param string|null $sortBy
     * @param string|null $direction
     * @return Builder
     */
    public function scopeFilters(Builder $query, ?string $sortBy, ?string $direction): Builder
    {
        return $query->when($sortBy, function (Builder $query, $sortBy) use ($direction) {
            switch ($sortBy) {
                case 'name':
                    return $query->orderBy('name', $direction ?? 'ASC');
                case 'status':
                    return $query->orderByStatus($direction);
                case 'analysis':
                    return $query->orderByLikesAndReviewsCount($direction);
                default:
                    throw new RuntimeException('SortBy parameter is missing.');
            }
        });
    }

    /**
     * Scope a query to order by status.
     *
     * @param Builder $query
     * @param string|null $direction
     * @return Builder
     */
    public function scopeOrderByStatus(Builder $query, ?string $direction): Builder
    {
        return $query->orderBy(DB::raw(
            "CASE
                WHEN status = 'available' THEN 1
                WHEN status = 'unavailable' THEN 2
                WHEN status = 'discontinued' THEN 3
                ELSE 4
            END"
        ), $direction ?? 'ASC');
    }

    /**
     * Scope a query to order by likes and reviews count.
     *
     * @param Builder $query
     * @param string|null $direction
     * @return Builder
     */
    public function scopeOrderByLikesAndReviewsCount(Builder $query, ?string $direction): Builder
    {
        return $query->orderBy(DB::raw(
            "likes_count + (reviews_count * 5)"
        ), $direction ?? 'DESC');
    }
}
