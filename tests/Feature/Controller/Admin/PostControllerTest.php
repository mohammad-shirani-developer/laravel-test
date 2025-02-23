<?php

namespace Tests\Feature\Controller\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEmpty;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $middlewares= ['web', 'admin'];
    /**
     * A basic feature test example.
     */
    public function testIndexMethod(): void
    {
        $this->withoutExceptionHandling();
        Post::factory()->count(100)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('post.index'))
            ->assertOk()
            ->assertViewIs('admin.post.index')
            ->assertViewHas('posts', Post::latest()->paginate(15));

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }


    public function testCreateMethod(): void
    {
        $this->withoutExceptionHandling();
        Tag::factory()->count(20)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('post.create'))
            ->assertOk()
            ->assertViewIs('admin.post.create')
            ->assertViewHas('tags', Tag::latest()->get());

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }


    public function testEditMethod(): void
    {
        // $this->withoutExceptionHandling();
        $post = Post::factory()->create();

        Tag::factory()->count(20)->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('post.edit', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.edit')
            ->assertViewHasAll([
                'tags' => Tag::latest()->get(),
                'post' => $post
            ]);

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }

    public function testStoreMethod()

    {
        $user=User::factory()->admin()->create();
        $tags = Tag::factory()->count(rand(1, 5))->create();
        $data = Post::factory()
        ->state(['user_id'=>$user->id])
        ->make()
        ->toArray();

        

        $this
            ->withoutMiddleware()
            ->actingAs($user)
            ->post(route('post.store'), array_merge(
                ['tags' => $tags->pluck('id')->toArray()],
                $data
            ))
            // dd(session()->all());
            ->assertSessionHas('message', 'new post has been created')
            ->assertRedirect(route('post.index'));
            

        $this->assertDatabaseHas('posts', $data);

        $this->assertEquals(
            $tags->pluck('id')->toArray(),
            Post::where($data)->first()->tags()->pluck('id')->toArray()
        );

        $this->assertEquals(
            request()->route()->middleware(),
            $this->middlewares
        );
    }

    // public function testDestroyMethod()
    // {
    //     $post=Post::factory()
    //     ->hasTags(5)
    //     -> hasComments(1)
    //     ->create();

    //     $comment=$post->comments()->first();

    //     $this ->withoutMiddleware()
    //     ->actingAs(User::factory()->admin()->create())
    //     ->delete(route('post.destroy',$post->id))
    //     ->assertSessionHas('message', 'the post has been deleted')
    //     ->assertRedirect(route('post.index'));

    //     $this->assertDeleted($post)
    //     ->assertDeleted($comment)
    //     ->assertEmpty($post->tags);

    //     $this->assertEquals(
    //         request()->route()->middleware(),
    //         $this->middlewares
    //     );
    // }
}
