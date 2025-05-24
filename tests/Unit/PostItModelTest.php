<?php

use App\Models\PostIt;
use App\Models\User;

test('post_it belongs to a user', function () {
    $postIt = PostIt::factory()->create();

    expect($postIt->user)
        ->toBeInstanceOf(User::class)
        ->and($postIt->user_id)->toBe($postIt->user->id);
});

test('user has many post_its', function () {
    $user = User::factory()->create();
    $postIts = PostIt::factory()->count(3)->for($user)->create();

    expect($user->postIts)->toHaveCount(3);
    expect($user->postIts->first())->toBeInstanceOf(PostIt::class);
});
