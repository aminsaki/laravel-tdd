<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    #/ empty datebase  for test
    use RefreshDatabase;

    /**
     *  this is count  row into database
     */
    public function test_insert_database()
    {
        # create users fack  in database
        //User::factory()->create();

        ///check count row  into  database
        //$this->assertDatabaseCount('users','1');

        /**************************************************************************/

        /// feact  col database  feact to vareble users
        $user = User::factory()->make()->toArray();
        $user['password'] = 123456;
        /// save to datebase
        User::create($user);
        /// check date insert  for date  datebase
        $this->assertDatabaseHas('users', $user);

    }

    /// relation  for  one ot hasMane
    public function test_users_Relation_ship_with_posts()
    {
        $count= rand(0,10);
                                 // one to hasMent
        $user=  User::factory()->hasPosts($count)->create();

        $this->assertCount($count, $user->posts);

        $this->assertTrue($user->posts->first() instanceof  Post);

    }
    /// hisMane To hisMane
    public function test_user_Relation_ship_with_comment()
    {
        $conut = rand(1, 10);

        $user = User::factory()->hasComments($conut)->create();

        $this->assertCount($conut ,$user->comments);
        $this->assertTrue($user->comments->first() instanceof Comment);

    }
}
