<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class OAuthController extends Controller
{
    private const PROVIDERS = ['google', 'apple'];

    /**
     * Redirect the user to the given OAuth provider.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->ensureSupported($provider);

        $driver = $this->driver($provider);

        return $provider === 'apple'
            ? $driver->scopes(['name', 'email'])->redirect()
            : $driver->redirect();
    }

    /**
     * Handle the callback coming back from the OAuth provider.
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->ensureSupported($provider);

        try {
            $socialUser = $this->driver($provider)->user();
        } catch (InvalidStateException $exception) {
            return redirect()->route('login')->withErrors([
                'email' => __('Gagal memverifikasi login via :provider. Silakan coba lagi.', ['provider' => ucfirst($provider)]),
            ]);
        }

        $user = User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName()
                    ?: $socialUser->getNickname()
                    ?: 'Pengguna BeriPeduli',
                'password' => Str::random(40),
            ],
        );

        Auth::login($user);

        return redirect()->to(config('fortify.home'));
    }

    /**
     * Reject any provider we do not support.
     */
    private function ensureSupported(string $provider): void
    {
        abort_unless(in_array($provider, self::PROVIDERS, true), 404);
    }

    /**
     * Build the Socialite driver, skipping state validation for Google in local
     * development to avoid InvalidStateException across the OAuth round-trip.
     */
    private function driver(string $provider): Provider
    {
        $driver = Socialite::driver($provider);

        if (app()->environment('local') && $provider === 'google') {
            $driver->stateless();
        }

        return $driver;
    }
}
