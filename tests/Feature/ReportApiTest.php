<?php
// tests/Feature/ReportApiTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportApiTest extends TestCase
{
    use RefreshDatabase;

    protected $store;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $setup = $this->createStoreWithAdmin();
        $this->store = $setup['store'];
        $this->user = $setup['user'];
    }

    /** @test */
    public function test_user_can_get_dashboard_stats()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/dashboard-stats');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'today' => ['revenue', 'transactions'],
                'this_week' => ['revenue'],
                'this_month' => ['revenue', 'transactions'],
                'alerts' => ['low_stock'],
                'chart' => ['last_7_days']
            ]
        ]);
    }

    /** @test */
    public function test_user_can_get_dashboard_chart_7days()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/dashboard/chart?period=7days');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'labels',
                'values'
            ]
        ]);

        $data = $response->json('data');
        $this->assertCount(7, $data['labels']);
        $this->assertCount(7, $data['values']);
    }

    /** @test */
    public function test_user_can_get_dashboard_chart_30days()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/dashboard/chart?period=30days');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'labels',
                'values'
            ]
        ]);

        $data = $response->json('data');
        $this->assertCount(30, $data['labels']);
        $this->assertCount(30, $data['values']);
    }

    /** @test */
    public function test_user_can_get_dashboard_chart_90days()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/api/v1/dashboard/chart?period=90days');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'labels',
                'values'
            ]
        ]);

        $data = $response->json('data');
        $this->assertCount(90, $data['labels']);
        $this->assertCount(90, $data['values']);
    }
}