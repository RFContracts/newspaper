<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

class PostTag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_tags';

    /**
     * Fillable params
     *
     * @var string[]
     */
    protected $fillable = ['post_id', 'tag_id'];

    /**
     * Gets Post
     *
     * @return hasOne
     */
    public function post()
    {
        return $this->hasOne(Post::class);
    }

    /**
     * Gets Tag
     *
     * @return hasOne
     */
    public function tag()
    {
        return $this->hasOne(Tag::class);
    }
}
