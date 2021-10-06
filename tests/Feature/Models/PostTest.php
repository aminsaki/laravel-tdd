<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase , ModelHelperTesting;



    /// relation  for  one ot blaneTo
    public function test_Post_Relation_ship_with_user()
    {

        $post = Post::factory()
            ->for(User::factory())
            ->create();
        $this->assertTrue(isset($post->user->id));
        $this->assertTrue($post->user instanceof User);

    }
      /// hisMane To hisMane
    public function test_Post_Relation_ship_with_tag()
    {
        $conut = rand(1, 10);

        $post = Post::factory()->hasTags($conut)->create();

        $this->assertCount($conut ,$post->tags);
        $this->assertTrue($post->tags->first() instanceof Tag);

    }

    /// hisMane To hisMane
    public function test_Post_Relation_ship_with_comment()
    {
        $conut = rand(1, 10);

        $post = Post::factory()->hasComments($conut)->create();

        $this->assertCount($conut ,$post->comments);
        $this->assertTrue($post->comments->first() instanceof Comment);

    }


    protected function model(): Model
    {
       return  new Post();
    }
}
