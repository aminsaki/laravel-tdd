<?php

namespace Tests\Feature\Models;

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
}
