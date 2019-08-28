<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * The attributes that are include to Post response .
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author',
        'likers',
        'user'
    ];

    /**
     * A Fractal transformer include.
     *
     * @return array
     */
    public function transform(Post $post)
    {

        return [
            'id' => $post->id,
            'body' => $post->body,
            'likes' => $post->likes->count(),
        ];
    }
    /**
     * A Fractal transformer include.
     *
     * @return array
     */
    public function includeAuthor(Post $post)
    {
        return $this->item($post->user, new UserTransformer());
    }
    /**
     * A Fractal transformer include.
     *
     * @return array
     */
    public function includeUser(Post $post)
    {
        return $this->item($post, new PostUserTransformer());
    }
    /**
     * A Fractal transformer include.
     *
     * @return array
     */
    public function includeLikers(Post $post)
    {
        return $this->collection($post->likers, new UserTransformer());
    }
}
