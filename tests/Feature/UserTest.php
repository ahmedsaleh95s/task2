<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{

    private $data, $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:client', ['--password' => true, '--no-interaction' => true, '--name' => 'User', '--provider' => 'users']);
        $this->user = User::factory()->create();
        $this->data = User::factory()->raw();
        Storage::fake('users');
        $file = UploadedFile::fake()->image('users.jpg');
        $this->data['photo'] = $file;

    }

    /** @test */
    public function store_user_successfully()
    {
        $response = $this->json('POST', route('register-user'), $this->data);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertSee("message");
    }

    /** @test */
    public function fail_to_store_user_successfully()
    {
        $this->data['email'] = $this->user->email;
        $response = $this->json('POST', route('register-user'), $this->data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function login_user_by_email_successfully()
    {
        $data['email'] = $this->user->email;
        $data['password'] = '12345678';
        $response = $this->json('POST', route('login-user'), $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function login_user_by_phone_successfully()
    {
        $data['email'] = $this->user->phone;
        $data['password'] = '12345678';
        $response = $this->json('POST', route('login-user'), $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function send_dynamic_link_for_user_successfully()
    {
        $data['email'] = $this->user->email;
        $response = $this->json('POST', route('forget-password'), $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("message");
    }

    /** @test */
    public function reset_password_for_user_successfully()
    {
        $data['email'] = $this->user->email;
        $data['password'] = '12345678';
        $data['token'] = $this->user->remember_token;
        $response = $this->json('POST', route('reset-password'), $data);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee("message");
    }
}
