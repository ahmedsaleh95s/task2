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

class ServiceProviderTest extends TestCase
{
    private $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = ServiceProvider::factory()->raw();
        Storage::fake('serviceProviders');
        $file = UploadedFile::fake()->image('serviceProviders.jpg');
        $this->data['avatar'] = $file;
        $file = UploadedFile::fake()->image('serviceProviders.pdf');
        $this->data['files'][] = $file;
        Admin::factory()->create();
        Category::factory(5)->create();
        $this->actingAs(Admin::first(), 'admin');
    }

    /** @test */
    public function store_Service_provider_successfully()
    {
        $response = $this->json('POST', route('storeServiceProvider'), $this->data);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertSee("message");
    }
}
