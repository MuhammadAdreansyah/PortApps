<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Google auth callback endpoint exists
     */
    public function test_google_auth_callback_endpoint_exists(): void
    {
        $response = $this->postJson(route('auth.google.callback'), [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'google_id' => 'google_123456',
            'avatar' => 'https://example.com/avatar.jpg'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'google_id' => 'google_123456',
        ]);
    }

    /**
     * Test validation requirements
     */
    public function test_google_auth_validation_fails_without_required_fields(): void
    {
        $response = $this->postJson(route('auth.google.callback'), [
            'email' => 'test@example.com',
            // Missing name and google_id
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'google_id']);
    }

    /**
     * Test invalid email format
     */
    public function test_google_auth_validation_fails_with_invalid_email(): void
    {
        $response = $this->postJson(route('auth.google.callback'), [
            'email' => 'not-an-email',
            'name' => 'Test User',
            'google_id' => 'google_123456',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Test user update if already exists
     */
    public function test_google_auth_updates_existing_user(): void
    {
        // Create user first
        $this->postJson(route('auth.google.callback'), [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'google_id' => 'google_123456',
            'avatar' => 'https://example.com/old-avatar.jpg'
        ]);

        // Update with new data
        $response = $this->postJson(route('auth.google.callback'), [
            'email' => 'test@example.com',
            'name' => 'Updated User',
            'google_id' => 'google_123456',
            'avatar' => 'https://example.com/new-avatar.jpg'
        ]);

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Updated User',
            'avatar' => 'https://example.com/new-avatar.jpg'
        ]);

        // Should only have one user
        $this->assertDatabaseCount('users', 1);
    }

    /**
     * Test user is authenticated after login
     */
    public function test_user_is_authenticated_after_google_login(): void
    {
        $response = $this->postJson(route('auth.google.callback'), [
            'email' => 'test@example.com',
            'name' => 'Test User',
            'google_id' => 'google_123456',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
    }

    /**
     * Test profile page requires authentication
     */
    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get(route('profile.show'));
        $response->assertRedirect(route('login'));
    }
}
