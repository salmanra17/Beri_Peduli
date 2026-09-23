<?php

use App\Models\Donasi;
use App\Models\Kampanye;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('dashboard renders in English when the user prefers English', function () {
    $user = User::factory()->create(['bahasa' => 'en']);
    $this->actingAs($user);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Hello')
        ->assertSee('Recent Donation History')
        ->assertSee('Amount')
        ->assertSee('Something New?')
        ->assertSee('Distribution Updates')
        ->assertSee('No donations yet. Time to start spreading kindness.')
        ->assertSee("Here's a summary of your activity on BeriPeduli. Keep spreading kindness.")
        ->assertDontSee('Riwayat Donasi Singkat');
});

test('dashboard shows the correct payment status badge based on status_pembayaran', function () {
    $user = User::factory()->create();

    $kampanye = Kampanye::factory()->create(['user_id' => $user->id]);

    Donasi::factory()->create([
        'user_id' => $user->id,
        'kampanye_id' => $kampanye->id,
        'status_pembayaran' => 'berhasil',
    ]);

    $this->actingAs($user);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Berhasil')
        ->assertDontSee('Gagal');
});
