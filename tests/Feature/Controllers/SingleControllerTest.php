<?php

namespace Tests\Feature\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;

class SingleControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_method()
    {
//        $this->withoutExceptionHandling(); //// show erros
        $post = Post::factory()->hasComments(rand(1, 3))->create();

        $response = $this->get(route('single', $post->id));
        $response->assertOk();
        $response->assertViewIs('single');
        $response->assertViewHasAll([
            'post' => $post,
            'comments' => $post->comments()->orderBy('id', 'desc')->paginate(15)
        ]);

    }

    /**
     * method test ajax   Login users
     */
    public function test_Comment_Method_When_User_Login()
    {
//       $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'user_id' => $user->id,
            'commentable_id' => $post->id
        ])->make()->toArray();

        $response = $this->actingAs($user)->post(route('single.comment', $post->id), ['text' => $data['text']]);
        $response->assertRedirect(route('single', $post->id));
        $this->assertDatabaseHas('comments', $data);

    }

    /**
     * method test ajax   Login users
     */
    public function test_Comment_Method_When_User_Login_ajax()
    {
//       $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'user_id' => $user->id,
            'commentable_id' => $post->id
        ])->make()->toArray();

        $response = $this->actingAs($user)->
         withHeaders([
             'HTTP_X-Requested-with'=>'XMLHTTPRequest'
        ])
        ->postJson(route('singleAjax.comment', $post->id), ['text' => $data['text']]);

         $response->assertOk() ;
         $response->assertJson([
             'status'=>'true'
         ]);

         $this->assertDatabaseHas('comments', $data);

    }

    /**
     * method test ajax  not Login users
     */
    public function test_Comment_Method_When_User_Not_Login()
    {
//       $this->withoutExceptionHandling();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'commentable_id' => $post->id
        ])->make()->toArray();

         unset($data['user_id']);

        $response = $this->post(route('single.comment', $post->id), ['text' => $data['text']]);

        $response->assertRedirect(route('login'));   //401
        $this->assertDatabaseMissing('comments', $data);

    }

    /**
     * method test ajax  not Login users  to ajax
     */
    public function test_Comment_Method_When_User_Not_Login_ajax()
    {
//       $this->withoutExceptionHandling();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'commentable_id' => $post->id
        ])->make()->toArray();

        unset($data['user_id']);

        $response = $this->
        withHeaders([
            'HTTP_X-Requested-with'=>'XMLHTTPRequest'
        ])
        ->postJson(route('singleAjax.comment', $post->id), ['text' => $data['text']]);

        $response->assertUnauthorized();   //401
        $this->assertDatabaseMissing('comments', $data);

    }

    /**
     *   method test and validtion data
     */

    public function test_Comment_Method_validtion_RequireData()
    {
//       $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'user_id' => $user->id,
            'commentable_id' => $post->id
        ])->make()->toArray();

//        $response = $this->actingAs($user)->post(route('single.comment', $post->id), ['text' => $data['text']]);
          $response = $this->actingAs($user)->post(route('single.comment', $post->id), ['text' =>""]);
          $response->assertSessionHasErrors(['text'=>'The text field is required.']);
    }

    /**
     *  method test  ajax and validtion data
     */
    public function test_Comment_Method_validtion_RequireData_ajax()
    {
//       $this->withoutExceptionHandling();
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $data = Comment::factory()->state([
            'user_id' => $user->id,
            'commentable_id' => $post->id
        ])->make()->toArray();


        $response = $this->
        withHeaders([
            'HTTP_X-Requested-with'=>'XMLHTTPRequest'
        ])->actingAs($user)
            ->postJson(route('singleAjax.comment', $post->id), ['text' =>""]);
         $response->assertJsonValidationErrors(['text'=>'The text field is required.']);
    }

}























