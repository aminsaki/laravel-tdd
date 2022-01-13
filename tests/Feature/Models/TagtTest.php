<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagtTest extends TestCase
{
    use RefreshDatabase , ModelHelperTesting;


    /// hisMane To hisMane
    public function test_tag_Relation_ship_with_post()
    {
        $conut = rand(1, 10);

        $tag = Tag::factory()->hasPosts($conut)->create();

        $this->assertCount($conut ,$tag->posts);
        $this->assertTrue($tag->posts->first() instanceof Post);

    }

    /**
     * @return Model
     */
    protected function model(): Model
    {
        return  new Tag();
    }
}
