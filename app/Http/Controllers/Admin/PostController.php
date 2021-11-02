<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.index', [

            'posts' => Post::orderBy('id', 'desc')->paginate(15)

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create', [
            'tags' => Tag::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(PostRequest $request)
    {
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'decription' => $request->decription,
            'image' => $request->image
        ]);

        $post->tags()->attach($request->tags);

        return redirect(route('post.index'))->with('messages', 'save post');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {

        return view('admin.post.show', [

            'posts' => Post::find($id)

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        return view('admin.post.edit', [
            'tags' => Tag::all(),
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\post $post
     * @return \Illuminate\Contracts\Foundation\Application|
     * \Illuminate\Http\RedirectResponse|
     * \Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(PostRequest $request  )
    {

        $post = Post::whereId($request->id)->first();
        $post->update([
            'title' => $request->title,
            'decription' => $request->decription,
            'image' => $request->image
        ]);

        $post->tags()->sync($request->input('tags'));



        return redirect(route('post.index'))->with('messages', 'update post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(post $post)
    {
        $result = $post->delete();
        if ($result) {
            return redirect()->route('post.index')->with('messages', "true");
        }
        return redirect()->route('post.index')->with('messages', "false");

    }
}
