<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\UserActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class UserActivityMiddlewareTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCanSetUserActivityInCachWhenUserLoggedIn(): void
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $request=Request::create('/admin','GET');

        $midddleware= new UserActivity();

        $responce=$midddleware->handle($request,function(){});

        $this->assertNull($responce);
        $this->assertEquals("online",Cache::get("user-{$user->id}-status"));
        $this->travel(11)->seconds();
        $this->assertNull(Cache::get("user-{$user->id}-status"));
    }


    public function testCanSetUserActivityInCachWhenUserNotLoggedIn(): void
    {
       

        $request=Request::create('/admin','GET');

        $midddleware= new UserActivity();

        $responce=$midddleware->handle($request,function(){});

        $this->assertNull($responce);
 
    }

    public function testUserActivityMiddlewareSetInWebMiddlewareGroup()
    {
        $user=User::factory()->create();

        $this
        ->actingAs($user)
        ->get(route('home'))
        ->assertOk();

        $this->assertEquals("online",Cache::get("user-{$user->id}-status"));

        $this->assertEquals(\request()->route()->middleware(),['web']);

    
    }
}
