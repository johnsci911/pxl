<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
        ]
    ]));

    return view('profile', compact('feedItems'));
});
