<?php

use App\Eloquent\Post;
use App\Eloquent\PostTag;
use Faker\Factory;
use Illuminate\Database\Seeder;

/**
 * Class PostsSeeder
 */
class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ru_RU');
        for ($i = 1; $i <= 10; $i++) {
            $form = collect([
                'title' => $faker->text(64),
                'description' => $faker->text(200),
                'user_id' => 1,
            ]);
            $post = Post::create($form->toArray());

            for ($b = 1; $b <= 4; $b++) {
                $id = $faker->biasedNumberBetween(1, 10);
                $pt = PostTag::where('post_id', $post->id)->where('tag_id', $id)->first();
                if (!$pt) {
                    $form = collect([
                        'post_id' => $post->id,
                        'tag_id' => $id
                    ]);
                    PostTag::create($form->toArray());
                }
            }
        }
    }
}
