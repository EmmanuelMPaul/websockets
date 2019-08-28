<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * check if user is authenticated
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all posts
     *
     * @return array
     */
    public function index()
    {
        $posts = Post::latest()->get();

        return  fractal()
            ->collection($posts)
            ->transformWith(new PostTransformer())
            ->toArray();
    }
    /**
     * Show the single post
     *  @param post
     * @return array
     */
    public function show(Post $post)
    {
        $posts = Post::latest()->get();

        return  fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray();
    }
    /**
     * store post to database.
     * @param $request
     * @return array
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $post = $request->user()->posts()->create($request->only('body'));

        broadcast(new PostCreated($post))->toOthers(); // broadcast to others

        return  fractal()
            ->item($post)
            ->transformWith(new PostTransformer())
            ->toArray();
    }
}
