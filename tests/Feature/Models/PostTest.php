<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     *
     */
    public function test_insert_date_to_datebase()
    {

        $post = Post::factory()->make()->toArray();

        Post::create($post);

        $this->assertDatabaseHas('posts', $post);

    }
    /// relation  for  one ot blaneTo
    public function test_Post_Relation_ship_with_user(){

        $post = Post::factory()
            ->for(User::factory())
            ->create();
        $this->assertTrue(isset($post->user->id));
        $this->assertTrue($post->user instanceof User);

    }
}
