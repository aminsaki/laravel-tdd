<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_method_index()
    {
        $post = Post::factory(100)->create();
        $this->get(route('post.index'))
            ->assertOk()
            ->assertViewIs('admin.post.index')
            ->assertViewHas('posts', Post::orderBy('id', 'desc')->paginate(15));

    }

    public function test_method_create()
    {
//       $this->withoutExceptionHandling(); //// show erros

        Tag::factory(20)->create();
        $this->get(route('post.create'))
            ->assertOk()
            ->assertViewIs('admin.post.create')
            ->assertViewHas('tags', Tag::all());

    }

    /**
     *
     */
    public function test_method_edit()
    {
        $post = Post::factory()->create();
        Tag::factory(20)->create();

        $this->get(url('admin/post/edit', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.edit')
            ->assertViewHasAll([
                'tags' => Tag::all(),
                'post' => $post
            ]);
    }

    /**
     *
     */
    public function test_method_delete()
    {
        $post = Post::factory()->create();

        $this->get(url('admin/post/delete', $post->id))
            ->assertSessionHas('messages')
            ->assertStatus(302);
        $this->assertDatabaseMissing('posts',['id'=> $post->id]);
    }

}
