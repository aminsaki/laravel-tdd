<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
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
        $this->actingAs(User::factory()->admin()->create());

        $post = Post::factory(100)->create();
        $this->get(route('post.index'))
            ->assertOk()
            ->assertViewIs('admin.post.index')
            ->assertViewHas('posts', Post::orderBy('id', 'desc')->paginate(15));

        $this->assertEquals(request()->route()->middleware(),
            ['web', 'admin']
        );

    }

    public function test_method_create()
    {
//       $this->withoutExceptionHandling(); //// show erros
        $this->actingAs(User::factory()->admin()->create());


        Tag::factory(20)->create();
        $this->get(route('post.create'))
            ->assertOk()
            ->assertViewIs('admin.post.create')
            ->assertViewHas('tags', Tag::all());
        $this->assertEquals(request()->route()->middleware(),
            ['web', 'admin']
        );

    }

    /**
     *
     */
    public function test_method_edit()
    {
        $this->actingAs(User::factory()->admin()->create());


        $post = Post::factory()->create();
        Tag::factory(20)->create();

        $this->get(url('admin/post/edit', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.edit')
            ->assertViewHasAll([
                'tags' => Tag::all(),
                'post' => $post
            ]);
        $this->assertEquals(request()->route()->middleware(),
            ['web', 'admin']
        );
    }

    /**
     *
     */
    public function test_method_delete()
    {

        $this->actingAs(User::factory()->admin()->create());

        $post = Post::factory()->create();

        $this->get(url('admin/post/delete', $post->id))
            ->assertSessionHas('messages')
            ->assertStatus(302);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);

        $this->assertEquals(request()->route()->middleware(),
            ['web', 'admin']
        );
    }

    public function test_method_store()
    {
        $user = User::factory()->admin()->create();

        $tags = Tag::factory()->count(rand(1, 5))->create();
        $data =
            Post::factory()->state(['user_id' => $user->id])->make()->toArray();


        $this
            ->actingAs($user)
            ->post(route('post.store'), array_merge(['tags' => $tags->pluck('id')->toArray()], $data))
            ->assertRedirect(route('post.index'))
            ->assertSessionHas('messages', 'save post');


        $this->assertDatabaseHas('posts', $data);

        $this->assertEquals(
            $tags->pluck('id')->toArray(),
            post::where($data)->first()->tags()->pluck('id')->toArray()

        );


    }

    public function test_method_update()
    {

//        $this->withoutExceptionHandling(); //// show erros
        $user = User::factory()->admin()->create();
        $tags = Tag::factory()->count(rand(1, 5))->create();
        $post = Post::factory()
            ->state(['user_id' => $user->id])->hasTags(rand(1, 5))->create();
        $data = Post::factory()
            ->state([
                'user_id' => $user->id,
            ])->make()->toArray();

        $this
            ->actingAs($user)
            ->post(route('post.update', ['id' => $post->id]),
                array_merge([
                    'tags' => $tags->pluck('id')->toArray()],
                    $data)
            )
            ->assertSessionHas('messages', 'update post')
            ->assertRedirect(route('post.index'));

        $this->assertDatabaseHas('posts', array_merge(['id' => $post->id], $data));

        $this->assertEquals(
            $tags->pluck('id')->toArray(),
            post::where($data)->first()->tags()->pluck('id')->toArray()

        );
        $this->assertEquals(request()->route()->middleware(),
            ['web', 'admin']
        );
    }

    public function test_method_show()
    {
        $post = Post::factory()->create();
        $user = User::factory()->admin()->create();

        $this
            ->actingAs($user)
            ->get(route('post.show', $post->id))
            ->assertOk()
            ->assertViewIs('admin.post.show')
            ->assertViewHas('posts', Post::find($post->id));
        $this->assertEquals(request()->route()->middleware(),
            ['web', 'admin']
        );


    }

    public function test_validationRequest()
    {

        $user = User::factory()->admin()->create();

        $data = [];
        $errors = [
            'title' => 'The title field is required.',
            'decription' => 'The decription field is required.',
            'image' => 'The image field is required.',
            'tags' => 'The tags field is required.',
        ];

        $this
            ->actingAs($user)
            ->post(route('post.store'), $data)
            ->assertSessionHasErrors($errors);


        $this
            ->actingAs($user)
            ->post(route('post.update'), $data)
            ->assertSessionHasErrors($errors);

    }


}






























