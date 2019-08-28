<?php

namespace App;

use App\User;
use App\Like;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * maximum user likes to a post.
     *
     * @var const int
     */
    const MAX_lIKES = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body'
    ];

    /**
     * define user and post relationship.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * define post to likes relationship.
     *
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     *declare post liker relation to like and post.
     *
     */
    public function likers()
    {
        return $this->hasManyThrough(
            User::class,
            Like::class,
            'likeable_id',
            'id',
            'id',
            'user_id'
        )
            ->where('likeable_type', Post::class)
            ->groupBy('likes.user_id', 'users.id', 'likes.likeable_id');
    }
    /**
     * check loginin user remaining limit to like a post
     * @var Object
     */
    public function likesRemainingFor(User $user)
    {
        return self::MAX_lIKES - $this->likes->where('user_id', $user->id)->count();
    }
    /**
     * check loginin user has reached liking limit
     * @var Object
     */
    public function maxLikesReachedFor(User $user)
    {
        return $this->likesRemainingFor($user) <= 0;
    }
}
