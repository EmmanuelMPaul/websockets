<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostUserTransformer extends TransformerAbstract
{
    /**
     * The attributes that are include to Post User response .
     *
     * @var array
     */
    protected $defaultIncludes = [
        'owner',
        'liked',
        'likes_remaining'
    ];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [];
    }
    /**
     * A Fractal transformer include post owner.
     *
     * @return array
     */
    public function includeOwner(Post $post)
    {
        return $this->primitive($post, function ($post) {
            return optional(auth()->user())->id === $post->user_id;
        });
    }
    /**
     * A Fractal transformer include liked post.
     *
     * @return array
     */
    public function includeliked(Post $post)
    {
        return $this->primitive($post, function ($post) {
            if (!$user = auth()->user()) {
                return false;
            }
            return $post->likers->contains($user);
        });
    }
    
    /**
     * A Fractal transformer include liking limit.
     *
     * @return array
     */
    public function includeLikesRemaining(Post $post)
    {
        return $this->primitive($post, function ($post) {
            if (!$user = auth()->user()) {
                return false;
            }
            return $post->likesRemainingFor($user);
        });
    }
}
