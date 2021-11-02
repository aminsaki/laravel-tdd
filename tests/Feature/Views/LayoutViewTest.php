<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LayoutViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_layout_view_Randerd_WhenUser_IsAdmin()
    {
        $user = User::factory()->state(['type' => 'admin'])->create();

        $this->actingAs($user);

        $view = $this->view('layouts.layout');
        $view->assertSee('<a href="admin/dashbord">admin panel</a>', false);
    }
    public function test_layout_view_Randerd_WhenUser_IsUser()
    {
        $user = User::factory()->state(['type' => 'user'])->create();

        $this->actingAs($user);

        $view = $this->view('layouts.layout');
        $view->assertDontSee('<a href="admin/dashbord">admin panel</a>', false);
    }
}
