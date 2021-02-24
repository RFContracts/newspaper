<?php

namespace Tests\Feature;

use App\Eloquent\Role;
use App\Eloquent\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class PostsTest extends TestCase
{
    use DatabaseMigrations;

    private $userData;
    private $postData;
    private $faker;

    /**
     * Setting up method
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();
        $this->seed();
		$this->faker = Faker::create();
        $this->generateUserData();
        $this->generatePostData();
    }

	/**
	 * Generate user data
	 */
    private function generateUserData()
	{
    	$this->userData = [
    		'name' => $this->faker->name,
			'email' => $this->faker->email,
			'password' => $this->faker->password
		];
	}

	/**
	 * Generate post data
	 */
    private function generatePostData()
	{
		$tags = [];
		for ($i = 0; $i >= rand(1, 10); $i++) {
			$tags[] = $this->faker->word;
		}

    	$this->postData = [
			'title' => $this->faker->title,
			'description' => $this->faker->text(20),
			'tags' => $tags
		];
	}

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test  */
    public function test_get_all_posts()
    {
        $count = DB::table('posts')->count();
        $response = $this->json('GET','/api/posts');
        $content = collect(json_decode($response->getContent()));

        $code = $content['code'];
        $message = $content['message'];
		$total = $content['total'];

		if ($code !== 200) {
            $this->assertTrue(false, $message);
        }

        if ($count !== $total) {
            $this->assertTrue(false, '$count and $total was different');
        }
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test  */
    public function test_create_new_post_default()
    {
        $this->json('POST', '/api/auth/register', $this->userData);

        $response = $this->json('POST', '/api/auth/login', $this->userData);

        $content = collect(json_decode($response->getContent()));

        $code = $content['code'];
        $message = $content['message'];

        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $token = $content['data']->token;

        for ($i = 0; $i >= rand(2, 10); $i++) {
			$tags[] = $this->faker->word;
		}

        $response = $this->json('POST','/api/posts', $this->postData, [
			'Authorization' => "Bearer $token"
		]);

        if ($response->getStatusCode() !== 401 && $response->getStatusCode() !== 403) {
            $this->assertTrue(false, 'Middleware doesn\'t work');
        }

        $response = $this->json(
            'POST',
            '/api/posts',
            $this->postData,
            ['Authorization' => 'Bearer $token']
        );

        $content = collect(json_decode($response->getContent()));

        $code = $content['code'];
        $message = $content['message'];

        $response->assertStatus(403);
	}


	/**
	 * A basic feature test example.
	 *
	 * @return void
	 */
	/** @test  */
	public function test_create_new_post_admin()
	{
		$user = [
			'name' => 'Admin',
			'email' => 'admin@test.ru',
			'password' => 'secret_pass'
		];

		$response = $this->json('POST', '/api/auth/login', $user);

		$response->assertStatus(200);

		$content = collect(json_decode($response->getContent()));

		$code = $content['code'];
		$message = $content['message'];

		if ($code !== 200) {
			$this->assertTrue(false, $message);
		}

		$token = $content['data']->token;

		$response = $this->json('POST','/api/posts', $this->postData, [
			'Authorization' => "Bearer $token"
		]);

		$response->assertStatus(200);

		$response = $this->json(
			'POST',
			'/api/posts',
			$this->postData,
			['Authorization' => 'Bearer $token']
		);

		$content = collect(json_decode($response->getContent()));

		$code = $content['code'];

		$response->assertStatus(200);
		$this->assertTrue($code === 200);
	}
}
