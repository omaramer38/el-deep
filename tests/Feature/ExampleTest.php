<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Root URL redirects based on Accept-Language.
     */
    public function test_root_redirects_to_localized_home(): void
    {
        $responseAr = $this->get('/', ['Accept-Language' => 'ar']);
        $responseAr->assertRedirect('/ar');

        $responseEn = $this->get('/', ['Accept-Language' => 'en']);
        $responseEn->assertRedirect('/en');
    }

    /**
     * Localized home page returns successful response with security headers.
     */
    public function test_localized_home_page_returns_successful_response(): void
    {
        $response = $this->get('/ar');
        $response->assertStatus(200);
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    /**
     * English localized home page returns 200.
     */
    public function test_english_home_page_returns_200(): void
    {
        $response = $this->get('/en');
        $response->assertStatus(200);
    }

    /**
     * Admin route requires authentication.
     */
    public function test_admin_requires_authentication(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    /**
     * Login page is accessible.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Elevators and Projects listing pages return 200.
     */
    public function test_elevators_and_projects_pages_render_successfully(): void
    {
        $responseElevators = $this->get('/en/elevators');
        $responseElevators->assertStatus(200);

        $responseProjects = $this->get('/en/projects');
        $responseProjects->assertStatus(200);
    }
}
