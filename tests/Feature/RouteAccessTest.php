<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    /**
     * Test that public landing pages are accessible without authentication.
     */
    public function test_public_pages_are_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $responseAbout = $this->get('/about');
        $responseAbout->assertStatus(200);

        $responseServices = $this->get('/services');
        $responseServices->assertStatus(200);

        $responseContact = $this->get('/contact');
        $responseContact->assertStatus(200);
    }

    /**
     * Test that login page is accessible directly by url.
     */
    public function test_admin_login_is_accessible(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /**
     * Test that admin dashboard and IMS modules redirect to login when unauthenticated.
     */
    public function test_protected_routes_redirect_to_login(): void
    {
        $responseDashboard = $this->get('/admin');
        $responseDashboard->assertRedirect('/admin/login');

        $responseWarehouseItems = $this->get('/admin/warehouse/items');
        $responseWarehouseItems->assertRedirect('/admin/login');
    }
}
