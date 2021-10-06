<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;

trait ModelHelperTesting
{


    public function test_insert_date_to_datebase()
    {
        $mode=  $this->model();
        $table= $mode->getTable();

        $result = $mode::factory()->make()->toArray();

        if($mode instanceof  User)
            $result['password'] = 123456;

        $mode::create($result);

        $this->assertDatabaseHas($table, $result);

    }

    abstract protected  function model() : Model;
}
