<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_insert_date_to_datebase()
    {
        $comments = Comment::factory()->make()->toArray();

        Comment::create($comments);

        $this->assertDatabaseHas('comments', $comments);

    }
}
