<?php

namespace Tests\Feature\Views;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SingleViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_single_view_rander_when_user_loggoIn()
    {
       $post =Post::factory()->create();
       $user = User::factory()->create();
       $action = route('single.comment', $post->id);

        $coments=  [];
       $view = (string) $this
           ->actingAs($user)
            ->view('single',['post'=> $post, 'comments'=> $coments]);
       $dom = new \DOMDocument();
       $dom->loadHTML($view);
       $dom = new \DOMXPath($dom);

       $this->assertCount(1,
//         if  dom int div    //  else /
         $dom->query("//form[@method='post'][@action='$action']/textarea[@name='text']")
       );


    }

    public function test_single_view_rander_when_user_not_loggoIn()
    {
        $post =Post::factory()->create();
        $action = route('single.comment', $post->id);

        $coments=  [];
        $view = (string) $this
             ->view('single',['post'=> $post, 'comments'=> $coments]);
        $dom = new \DOMDocument();
        $dom->loadHTML($view);
        $dom = new \DOMXPath($dom);

        $this->assertCount(0,
//         if  dom int div    //  else /
            $dom->query("//form[@method='post'][@action='$action']/textarea[@name='text']")
        );


    }
}
