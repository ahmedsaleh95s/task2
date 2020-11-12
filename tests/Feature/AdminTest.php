<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Admin;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class AdminTest extends TestCase
{

    private $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:client', ['--password' => true, '--no-interaction' => true, '--name' => 'Admin', '--provider' => 'admins']);
        Admin::factory()->create();
    }

    /** @test */
    public function login_admin_successfully()
    {
        $data['email'] = Admin::first()->email;
        $data['password'] = '12345678';
        $response = $this->json('POST', route('admin-login'), $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function login_admin_Failure()
    {
        $data['email'] = Admin::first()->email;
        $data['password'] = '123456789';
        $response = $this->json('POST', route('admin-login'), $data);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
