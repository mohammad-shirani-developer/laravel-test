<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function testUserCanRegister(): void
    // {

    //     $data=User::factory()->user()->make(['email_veried_at'=>null])->toArray();

    //     $password='12345678';

    //     $response = $this->post(route('register',array_merge($data,[
    //         'password'=>$password,
    //         'password_confirmation'=>$password
    //     ])));

    //     $response->assertRedirect();

    //     $this->assertDatabaseHas('users',$data);
    // }
}
