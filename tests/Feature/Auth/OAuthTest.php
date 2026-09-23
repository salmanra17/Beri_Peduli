<?php

use App\Models\User;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

test('google redirect sends the user to the provider', function () {
    $driver = Mockery::mock(Provider::class);

    $driver->shouldReceive('redirect')->once()->andReturn(redirect('https://accounts.google.com'));

    Socialite::shouldReceive('driver')->with('google')->once()->andReturn($driver);

    $this->get(route('auth.redirect', 'google'))
        ->assertRedirect('https://accounts.google.com');
});

test('unsupported providers are rejected', function () {
    $this->get(route('auth.redirect', 'facebook'))
        ->assertNotFound();

    $this->get(route('auth.callback', 'facebook'))
        ->assertNotFound();
});

test('oauth callback authenticates an existing user by email', function () {
    $user = User::factory()->create(['email' => 'john@example.com']);

    $socialUser = new SocialiteUser;
    $socialUser->email = 'john@example.com';
    $socialUser->name = 'John Doe';

    $driver = Mockery::mock(Provider::class);
    $driver->shouldReceive('user')->once()->andReturn($socialUser);

    Socialite::shouldReceive('driver')->with('google')->once()->andReturn($driver);

    $this->get(route('auth.callback', 'google'))
        ->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

test('oauth callback creates and authenticates a new user', function () {
    $socialUser = new SocialiteUser;
    $socialUser->email = 'new@example.com';
    $socialUser->name = 'Dewi';

    $driver = Mockery::mock(Provider::class);
    $driver->shouldReceive('user')->once()->andReturn($socialUser);

    Socialite::shouldReceive('driver')->with('google')->once()->andReturn($driver);

    $this->get(route('auth.callback', 'google'))
        ->assertRedirect('/dashboard');

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'new@example.com',
        'name' => 'Dewi',
    ]);
});
