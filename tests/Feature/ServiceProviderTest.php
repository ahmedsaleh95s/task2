<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Admin;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Category;
use Database\Factories\LocationFactory;

class ServiceProviderTest extends TestCase
{
    private $data, $serviceProvider;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = ServiceProvider::factory()->raw();
        Storage::fake('serviceProviders');
        $file = UploadedFile::fake()->image('serviceProviders.jpg');
        $this->data['avatar'] = $file;
        $file = UploadedFile::fake()->image('serviceProviders.pdf');
        $this->data['files'][] = $file;
        $admin = Admin::factory()->create();
        Category::factory(5)->create();
        $this->actingAs(Admin::first(), 'admin');
    }

    /** @test */
    public function store_Service_provider_successfully()
    {
        $response = $this->json('POST', route('store-service-provider'), $this->data);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertSee("message");
    }

    /** @test */
    public function list_all_Service_provider()
    {
        $response = $this->json('GET', route('all-service-provider'));
        $response->assertStatus(Response::HTTP_OK);
    }

    // /** @test */
    public function show_Service_provider_data()
    {
        $response = $this->json('GET', route('show-service-provider', ['service_provider' => 2]));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function update_Service_provider_data()
    {
        $response = $this->json('PUT', route('update-service-provider', ['service_provider' => 2]), $this->data);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function delete_Service_provider_data()
    {
        $response = $this->json('DELETE', route('delete-service-provider', ['service_provider' => 4]));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function login_Service_provider_successfully()
    {
        $data['email'] = ServiceProvider::first()->email;
        $data['password'] = '12345678';
        $response = $this->json('POST', route('service-provider-login'), $data);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function list_Service_provider_by_location()
    {
        $response = $this->json('GET', route('user-distance', ['lat' => 28.302938, 'long' => 57.718758]));
        $response->assertStatus(Response::HTTP_OK);
    }
}
