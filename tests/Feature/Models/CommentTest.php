<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase, ModelHelperTesting;


    /// hisMane To hisMane
    public function test_comment_Relation_ship_with_post()
    {

        $comment = Comment::factory()
            ->hasCommentable(Post::factory())
            ->create();

        $this->assertTrue(isset($comment->commentable->id));

        $this->assertTrue($comment->commentable instanceof Post);

    }
    /// hisMane To hisMane
    public function test_comment_Relation_ship_with_user()
    {

        $comment = Comment::factory()
            ->for(User::factory())
            ->create();

        $this->assertTrue(isset($comment->user->id));

        $this->assertTrue($comment->user instanceof User);

    }
    /**
     * @return Model
     */
    protected function model(): Model
    {
        return  new Comment();
    }
}
