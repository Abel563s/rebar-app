<?php

namespace Tests\Feature;

use App\Models\ProjectSite;
use App\Models\RebarRequirement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RebarReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reports_page_loads_successfully_for_authenticated_admin()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $site = ProjectSite::create([
            'site_code' => 'TEST-REP',
            'site_name' => 'Report Test Site',
            'project_name' => 'Test Project',
            'location' => 'Test Location',
            'status' => 'Active',
            'steel_grade' => '500',
        ]);

        RebarRequirement::create([
            'tracking_id' => 'REQ-REP-1',
            'structural_element' => 'Column C1',
            'bar_diameter' => 16,
            'required_length' => 4.50,
            'quantity' => 20,
            'total_length' => 90.00,
            'user_id' => $admin->id,
            'site_id' => $site->id,
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.rebar.reports'));

        $response->assertStatus(200);
        $response->assertSee('Operational Intelligence');
        $response->assertSee('Report Test Site');
        $response->assertSee('TEST-REP');
        $response->assertSee('Bar Diameter Calibration');
        $response->assertSee('Grade 500');
    }
}
