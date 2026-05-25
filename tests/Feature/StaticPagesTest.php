<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaticPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_loads(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('About');
    }

    public function test_contact_page_loads(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Contact');
    }

    public function test_faq_page_loads(): void
    {
        $response = $this->get('/faq');
        $response->assertStatus(200);
    }

    public function test_terms_page_loads(): void
    {
        $response = $this->get('/terms-of-use');
        $response->assertStatus(200);
    }

    public function test_privacy_page_loads(): void
    {
        $response = $this->get('/privacy-policy');
        $response->assertStatus(200);
    }

    public function test_disclaimer_page_loads(): void
    {
        $response = $this->get('/disclaimer');
        $response->assertStatus(200);
    }

    public function test_return_policy_page_loads(): void
    {
        $response = $this->get('/return-policy');
        $response->assertStatus(200);
    }

    public function test_care_instructions_page_loads(): void
    {
        $response = $this->get('/care-instructions');
        $response->assertStatus(200);
    }
}
