<?php

use App\Models\PostIt;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('unauthenticated user cannot access post-its endpoints', function () {
    $this->getJson('/api/post-its')->assertUnauthorized();
    $this->postJson('/api/post-its', [])->assertUnauthorized();
    $this->getJson('/api/post-its/1')->assertUnauthorized();
    $this->putJson('/api/post-its/1', [])->assertUnauthorized();
    $this->deleteJson('/api/post-its/1')->assertUnauthorized();
});

test('can get paginated list of post-its', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    PostIt::factory()->count(15)->create();

    $response = $this->getJson('/api/post-its');

    $response->assertOk()
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'description', 'color', 'font_family', 'font_size', 'size', 'created_at', 'user']
            ],
            'links',
            'meta'
        ]);
});

test('can filter post-its by color', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    PostIt::factory()->count(3)->create(['color' => 'blue']);
    PostIt::factory()->count(2)->create(['color' => 'yellow']);

    $response = $this->getJson('/api/post-its?color=blue');

    $response->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonPath('data.0.color', 'blue');
});

test('can create a post-it', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postItData = [
        'title' => 'Test Post-it',
        'description' => 'This is a test',
        'color' => 'green',
        'font_family' => 'Arial',
        'font_size' => 'small',
        'size' => 'M',
    ];

    $response = $this->postJson('/api/post-its', $postItData);

    $response->assertCreated()
        ->assertJsonPath('data.title', 'Test Post-it')
        ->assertJsonPath('data.user.id', $user->id);

    $this->assertDatabaseHas('post_its', [
        'user_id' => $user->id,
        'title' => 'Test Post-it',
    ]);
});

test('cannot create a post-it with invalid data', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $response = $this->postJson('/api/post-its', [
        'title' => '',
        'color' => 'invalid-color',
        'size' => 'XL',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['title', 'color', 'size', 'font_family', 'font_size']);
});

test('can get a single post-it', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postIt = PostIt::factory()->for($user)->create();

    $response = $this->getJson("/api/post-its/{$postIt->id}");

    $response->assertOk()
        ->assertJsonPath('data.id', $postIt->id)
        ->assertJsonPath('data.title', $postIt->title);
});

test('can update a post-it', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postIt = PostIt::factory()->for($user)->create();

    $response = $this->putJson("/api/post-its/{$postIt->id}", [
        'title' => 'Updated Title',
        'color' => 'pink',
    ]);

    $response->assertOk()
        ->assertJsonPath('data.title', 'Updated Title')
        ->assertJsonPath('data.color', 'pink');

    $this->assertDatabaseHas('post_its', [
        'id' => $postIt->id,
        'title' => 'Updated Title',
        'color' => 'pink',
    ]);
});

test('cannot update a post-it with invalid data', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postIt = PostIt::factory()->for($user)->create();

    $response = $this->putJson("/api/post-its/{$postIt->id}", [
        'color' => 'invalid-color',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['color']);
});

test('can delete a post-it', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $postIt = PostIt::factory()->for($user)->create();

    $response = $this->deleteJson("/api/post-its/{$postIt->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('post_its', ['id' => $postIt->id]);
});
