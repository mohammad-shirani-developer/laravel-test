<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadImageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $middlewares = ['web', 'admin'];

    /**
     * A basic feature test example.
     */
    public function testUploadMethodCanUploadImage(): void
    {
        $image = UploadedFile::fake()->image('image.png');

        $this->withoutMiddleware()
            ->actingAs(User::factory()->admin()->create())
            ->withHeaders([
                'HTTP_X-Requsted-with' => 'XMLHttpRequset',
            ])
            ->postJson(route('upload'), compact('image'))
            ->assertOk()
            ->assertJson(['url' => "/upload/{$image->hashName()}"]);

        $this->assertFileExists(public_path("/upload/{$image->hashName()}"));

        $this->assertEquals(request()->route()->middleware(), $this->middlewares);
    }
}
