<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class HardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_applied(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self), payment=(), usb=()')
            ->assertHeaderMissing('X-Powered-By');

        $this->assertStringContainsString("frame-ancestors 'none'", $response->headers->get('Content-Security-Policy'));
    }

    public function test_hsts_is_only_applied_to_https_requests(): void
    {
        $this->get('/')->assertHeaderMissing('Strict-Transport-Security');
        $this->get('https://localhost/')->assertHeader('Strict-Transport-Security', 'max-age=31536000');
    }

    public function test_login_is_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/login', [
                'nomor_telepon' => '081234567890',
                'password' => 'salah',
            ])->assertUnauthorized();
        }

        $this->postJson('/login', [
            'nomor_telepon' => '081234567890',
            'password' => 'salah',
        ])->assertStatus(429);
    }

    public function test_user_login_returns_to_an_intended_checkout_url(): void
    {
        $user = User::create([
            'name' => 'Pengguna Test',
            'nomor_telepon' => '081234567899',
            'password' => Hash::make('password123'),
            'role' => 'pengguna',
        ]);

        $this->get(route('login', ['redirect' => route('cart.checkout')]))->assertOk();

        $this->postJson('/login', [
            'nomor_telepon' => $user->nomor_telepon,
            'password' => 'password123',
        ])->assertJsonPath('redirect', route('cart.checkout'));
    }

    public function test_homepage_navigation_and_map_are_accessible(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('href="'.route('home').'#about"', false)
            ->assertSee('href="'.route('home').'#location"', false)
            ->assertSee('aria-label="Peta lokasi Bengkelin Sidoarjo"', false)
            ->assertDontSee('/tentang-kami', false)
            ->assertDontSee('/lokasi', false);
    }

    public function test_guest_cart_is_available_without_erasing_local_storage(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('window.addToCart = function(item)', false)
            ->assertSee(route('login', ['redirect' => route('cart.checkout')]), false)
            ->assertDontSee("localStorage.removeItem('bengkelin_cart')", false);
    }
}
