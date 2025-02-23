<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\CheckUserIsAdmin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Queue\SqsQueue;
use Tests\TestCase;

class CheckUserIsAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function testWhenUserIsNotAdmin(): void
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $request=Request::create('/admin','GET');

        $midddleware= new CheckUserIsAdmin();

        $responce=$midddleware->handle($request,function(){});

        $this->assertEquals($responce->getStatusCode(),302);

    }

    /**
     * A basic feature test example.
     */
    public function testWhenUserIsAdmin(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user);

        $request=Request::create('/admin','GET');

        $midddleware= new CheckUserIsAdmin();

        $responce=$midddleware->handle($request,function(){});

        $this->assertEquals($responce,null);

    }
    /**
     * A basic feature test example.
     */
    public function testWhenUserIsNotLoggedIn(): void
    {
        $request=Request::create('/admin','GET');

        $midddleware= new CheckUserIsAdmin();

        $responce=$midddleware->handle($request,function(){});

        $this->assertEquals($responce->getStatusCode(),302);

    }
}
