<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagtTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_insert_date_in_databaset()
    {
        /// feact  col database  feact to vareble users
        $tag = Tag::factory()->make()->toArray();

        /// save to datebase
        Tag::create($tag);
        /// check date insert  for date  datebase
        $this->assertDatabaseHas('tags', $tag);
    }

    /// hisMane To hisMane
    public function test_tag_Relation_ship_with_post()
    {
        $conut = rand(1, 10);

        $tag = Tag::factory()->hasPosts($conut)->create();

        $this->assertCount($conut ,$tag->posts);
        $this->assertTrue($tag->posts->first() instanceof Post);



    }
}
