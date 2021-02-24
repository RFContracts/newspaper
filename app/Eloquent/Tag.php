<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Tag extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['name'];

    /**
     * Check and create new tags
     *
     * @param $tags
     * @param null $id
     * @return Collection
     */
    public static function checkTags($tags, $id = null)
    {
        $tagsCollect = collect();
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            if ($id !== null) {
                PostTag::firstOrCreate(['post_id' => $id, 'tag_id' => $tag->id]);
            }
            $tagsCollect->push($tag);
        }

        return $tagsCollect;
    }
}
