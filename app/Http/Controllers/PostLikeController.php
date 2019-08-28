<?php

namespace App\Http\Controllers;

use App\Events\PostLiked;
use App\Post;
use App\User;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostLikeController extends Controller
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
     * store like 
     * @param $request $post
     * @return array
     */
    public function store(Request $request,  Post $post)
    {

        //check if user owns the post
        if ($post->user_id === $request->user()->id) {
            return response(null, 403);
        }
         //check if user has reached liking limit 
        if ($post->maxLikesReachedFor($request->user())) {
            return response(null, 429);
        }

        // create new post
        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        // broadcast created post to others
        broadcast(new PostLiked($post))->toOthers(); 

        // return the post to the creater
        return  fractal()
            ->item($post->fresh())
            ->transformWith(new PostTransformer())
            ->toArray();
    }
}
