<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Contracts\View\Factory|
     * \Illuminate\Contracts\View\View
     */
    public function index(Post $post)
    {
        return view('single', [
            'post' => $post,
            'comments' => $post->comments()->orderBy('id', 'desc')->paginate(15)
        ]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function comment(Request $request, Post $post)
    {
        $request->validate(['text'=>'required']);

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'text' => $request->text
        ]);

        return redirect()->route('single', $post->id);

    }

    /**
     * @param Request $request
     * @param Post $post
     * @return string[]
     */
    public function commenteAjax(Request $request, Post $post)
    {
        $request->validate(['text'=>'required']);

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'text' => $request->text
        ]);

        return ['status' => 'true'];

    }
}








