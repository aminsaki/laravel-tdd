<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\CheckUserIsAdmin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class CheckUserIsAdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;


    public function test_When_user_IsNot_Admin()
    {
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request ,function (){});

        $this->assertEquals($response->getStatusCode(), 302);

    }

    public function test_When_user_Is_Admin()
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request ,function (){});

        $this->assertEquals($response, null);

    }

    public function test_When_user_not_login()
    {

        $request = Request::create('/admin', 'GET');

        $middleware = new CheckUserIsAdmin();

        $response = $middleware->handle($request ,function (){});

        $this->assertEquals($response->getStatusCode(), 302);

    }
}
