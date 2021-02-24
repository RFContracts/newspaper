<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    private $userData;
    private $faker;

	/**
	 * Setup
	 */
    public function setUp() : void
    {
        parent::setUp();
        $this->seed();
		$this->faker = Faker::create();
		$this->generateUserData();
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
     * Sign In test.
     *
     * @return void
     */
    /** @test  */
    public function test_user_can_sign_in()
    {
        $response = $this->json('POST', '/api/auth/register', $this->userData);
        $content = collect(json_decode($response->getContent()));

        $code = $content['code'];
        $message = $content['message'];

        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }

        $response->assertStatus(200);
    }

    /**
     * Login test.
     *
     * @return void
     */
    /** @test  */
    public function test_user_can_login()
    {
        $this->json('POST', '/api/auth/register', $this->userData);

        $response = $this->json('POST', '/api/auth/login', $this->userData);

        $content = collect(json_decode($response->getContent()));

        $code = $content['code'];
        $message = $content['message'];

        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }

        $response->assertStatus(200);
    }

    /**
     * User info test.
     *
     * @return void
     */
    /** @test  */
    public function test_user_can_browse_info()
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
        $response = $this->get('/api/user', ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }
}
