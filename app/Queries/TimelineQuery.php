<?php

namespace App\Queries;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TimelineQuery
{
    public function __construct(private Profile $viewer)
    {

    }

    public static function forViewer(Profile $viewer)
    {
        return new self($viewer);
    }

    public function paginate(int $perPage = 20): LengthAwarePaginator
    {
        return $this->baseQuery()->paginate($perPage)->through(fn($post) => $this->normalize($post));
    }

    public function get(): Collection
    {
        return $this->baseQuery()->get()->map(fn($post) => $this->normalize($post));
    }

    public function baseQuery(): Builder
    {
        $followingIds = $this->viewer
            ->followings()
            ->pluck('following_profile_id')
            ->prepend($this->viewer->id);

        $posts = Post::whereIn('profile_id', $followingIds)
            ->whereNull('parent_id')
            ->with([
                'profile',
                'repostOf' => fn($q) => $q->withCount(['likes', 'replies', 'reposts'])
                    ->with(['profile'])
            ])
            ->withExists([
                'likes as has_liked' => fn($q) => $q->where('profile_id', $this->viewer->id),
                'reposts as has_reposted' => fn($q) => $q->where('profile_id', $this->viewer->id),
                'repostOf as liked_original' => fn($q) => $q
                    ->whereHas('likes', fn($q) => $q->where('profile_id', $this->viewer->id))
                    ->whereHas('reposts', fn($q) => $q->where('profile_id', $this->viewer->id))
            ])
            ->withCount(['likes', 'replies', 'reposts'])
            ->latest();

        return $posts;
    }

    private function normalize(Post $post): Post
    {
        if ($post->isRepost() && is_null($post->content)) {
            $post->repostOf->has_liked = (bool) $post->like_original;
            $post->repostOf->has_reposted = (bool) $post->repost_original;
        }

        return $post;
    }
}
