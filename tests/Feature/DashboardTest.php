<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get('/images');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the images', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/images');
    $response->assertStatus(200);
});