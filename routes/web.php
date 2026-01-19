<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dev/login', function () {
    $user = User::first('id', 5);

    Auth::login($user);

    request()->session()->regenerate();

    return redirect()->route('profiles.show', $user->profile);
})->name('login');

Route::get('/dev/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->intended('/feed');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::get('/feed', function () {
    $feedItems = json_decode(json_encode([
        [
            'content' => <<<str
                <p>
                    I made this! <a href="#">#myartwork</a> <a href="#">#pxl</a>
                </p>
                <img src="/images/simon-chilling.png" alt="" />
            str,
            'likeCount' => 23,
            'replyCount' => 45,
            'repostCount' => 151,
            'postedDateTime' => '3h',
            'profile' => [
                'avatar' => '/images/michael.png',
                'displayName' => 'Michael',
                'handle' => '@mmich_jj',
            ],
            'replies' => [
                [
                    'content' => <<<str
                        <p>Heh — this looks just like me!</p>
                    str,
                    'likeCount' => 52,
                    'replyCount' => 12,
                    'repostCount' => 200,
                    'postedDateTime' => '1h',
                    'profile' => [
                        'avatar' => '/images/simon-chilling.png',
                        'displayName' => 'Simon',
                        'handle' => '@simonswiss',
                    ],
                ],
                [
                    'content' => <<<str
                        <p>Heh — this is another one!</p>
                    str,
                    'likeCount' => 53,
                    'replyCount' => 22,
                    'repostCount' => 320,
                    'postedDateTime' => '1h 30m',
                    'profile' => [
                        'avatar' => '/images/simon-chilling.png',
                        'displayName' => 'Simon',
                        'handle' => '@simonswiss',
                    ],
                ]
            ]
        ]
    ]));

    return view('feed', compact('feedItems'));
});

Route::get('/profile', function () {
    $feedItems = json_decode(json_encode([
        [
            'content' => <<<str
              <p>
                I made this! <a href="#">#myartwork</a> <a href="#">#pxl</a>
              </p>
              <img src="/images/simon-chilling.png" alt="" />
            str,
            'likeCount' => 23,
            'replyCount' => 45,
            'repostCount' => 151,
            'postedDateTime' => '3h',
            'profile' => [
                'avatar' => '/images/michael.png',
                'displayName' => 'Michael',
                'handle' => '@mmich_jj',
            ],
            'replies' => [
                [
                    'content' => <<<str
                        <p>Heh — this looks just like me!</p>
                    str,
                    'likeCount' => 52,
                    'replyCount' => 12,
                    'repostCount' => 200,
                    'postedDateTime' => '1h',
                    'profile' => [
                        'avatar' => '/images/simon-chilling.png',
                        'displayName' => 'Simon',
                        'handle' => '@simonswiss',
                    ],
                ],
                [
                    'content' => <<<str
                        <p>Heh — this is another one!</p>
                    str,
                    'likeCount' => 53,
                    'replyCount' => 22,
                    'repostCount' => 320,
                    'postedDateTime' => '1h 30m',
                    'profile' => [
                        'avatar' => '/images/simon-chilling.png',
                        'displayName' => 'Simon',
                        'handle' => '@simonswiss',
                    ],
                ]
            ]
        ]
    ]));

    return view('profile', compact('feedItems'));
});

Route::get('/{profile:handle}', [ProfileController::class, 'show'])->name('profiles.show');
Route::get('/{profile:handle}/with_replies', [ProfileController::class, 'replies'])->name('profiles.replies');

Route::scopeBindings()->group(function () {
    Route::get('/{profile:handle}/status/{post}', [PostController::class, 'show'])->name('posts.show');
});
