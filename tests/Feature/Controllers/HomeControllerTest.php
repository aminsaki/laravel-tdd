<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *url =  check url  home index for users
     * @return void
     */
    public function test_index_method()
    {
        Post::factory()->count(100)->create();

        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertValid('home');
        $response->assertViewHas('posts',Post::orderBy('id','desc')->paginate(15));
    }
}
