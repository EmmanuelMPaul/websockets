<?php

namespace App\Http\Controllers;

use App\Events\PostLiked;
use App\Post;
use App\User;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request,  Post $post)
    {

        //  $this->authorize('like', $post);

        if ($post->user_id === $request->user()->id) {
            return response(null, 403);
        }
        if ($post->maxLikesReachedFor($request->user())) {
            return response(null, 429);
        }


        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        broadcast(new PostLiked($post))->toOthers(); // broadcast to others

        return  fractal()
            ->item($post->fresh())
            ->transformWith(new PostTransformer())
            ->toArray();
    }
}
