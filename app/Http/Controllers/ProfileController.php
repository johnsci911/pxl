<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile)
    {
        $profile->loadCount(['followings', 'followers']);

        $posts = Post::where('profile_id', $profile->id)
            ->whereNull('parent_id')
            ->with(
                ['repostOf' => fn($q) => $q->withCount(['likes', 'reposts', 'replies'])]
            )
            ->withCount(['likes', 'reposts', 'replies'])
            ->latest()
            ->get();

        return view('profiles.show', compact('profile', 'posts'));
    }

    public function replies(Profile $profile)
    {
        $profile->loadCount(['followings', 'followers']);

        $posts = Post::query()
            ->where(fn($q) => $q
                ->whereBelongsTo($profile, 'profile')
                ->whereNull('parent_id')
                ->withCount(['likes', 'reposts', 'replies'])
            )
            ->orWhereHas('replies', fn($q) => $q
                ->whereBelongsTo($profile, 'profile')
                ->withCount(['likes', 'reposts', 'replies'])
            )
            ->with([
                'profile',
                'repostOf' => fn($q) => $q
                    ->withCount(['likes', 'reposts', 'replies'])
                    ->with([
                        'profile', 'replies' => fn($q) => $q
                            ->withCount(['likes', 'reposts', 'replies'])
                            ->with('profile')
                            ->oldest()
                    ]),
                'repostOf.profile',
                'parent.profile',
                'replies' => fn($q) => $q
                    ->withCount(['likes', 'reposts', 'replies'])
                    ->with('profile')
                    ->oldest()
            ])
            ->withCount(['likes', 'reposts', 'replies'])
            ->latest()
            ->get();

        return view('profiles.replies', compact('profile', 'posts'));
    }

    public function follow(Profile $profile)
    {
        $currentProfile = Auth::user()->profile;

        $follow = Follow::createFollow($currentProfile, $profile);

        return response()->json(compact('follow'));
    }
}
