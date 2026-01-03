<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/feed', function () {
    $postForm = [
        'labelText' => 'Post body',
        'fieldName' => 'post',
        'placeholder' => 'What _adrian?',
    ];

    $replyForm = [
        'labelText' => 'Reply',
        'fieldName' => 'reply',
        'placeholder' => 'Reply to _adrian\'s post?',
        'rows' => 5
    ];

    return view('feed', compact('postForm', 'replyForm'));
});

Route::get('/profile', function () {
    return view('profile');
});
