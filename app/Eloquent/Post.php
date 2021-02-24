<?php

namespace App\Eloquent;

use App\Http\Filters\PostFilter;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Post extends Model
{
    use Filterable;
    use PostFilter;

    /**
     * The white list for filters
     *
     * @var string[]
     */
    private static $whiteListFilter = [
        'id',
        'title',
        'description',
        'created_at',
        'updated_at',

        // Custom filters:
        'title_like',
        'description_like',
        'tags',
        'sort_by',
    ];

    /**
     * Gets Tags[]
     *
     * @return HasManyThrough
     */
    public function tags()
    {
        return $this->hasManyThrough(Tag::class, PostTag::class, 'post_id', 'id', 'id', 'tag_id');
    }

	/**
	 * Gets Tags[]
	 *
	 * @return BelongsTo
	 */
    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
