<?php

namespace Tests\Feature;

use App\Models\Offcut;
use App\Models\ProjectSite;
use App\Models\RebarCuttingLog;
use App\Models\RebarRequirement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RebarCuttingLogTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected ProjectSite $site;
    protected RebarRequirement $requirement;
    protected Offcut $offcut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->site = ProjectSite::create([
            'site_code' => 'TEST-01',
            'site_name' => 'Test Site',
            'project_name' => 'Test Project',
            'location' => 'Test Location',
            'status' => 'Active',
            'steel_grade' => '500',
        ]);

        $this->requirement = RebarRequirement::create([
            'tracking_id' => 'REQ-01',
            'structural_element' => 'Beam B1',
            'bar_diameter' => 12,
            'required_length' => 6.00,
            'quantity' => 10,
            'total_length' => 60.00,
            'user_id' => $this->user->id,
            'site_id' => $this->site->id,
        ]);

        $this->offcut = Offcut::create([
            'offcut_code' => 'OFF-TEST',
            'site_id' => $this->site->id,
            'bar_diameter' => 12,
            'length' => 8.00,
            'quantity' => 5,
            'status' => 'Available',
        ]);
    }

    /** @test */
    public function it_can_reuse_an_available_offcut_and_decrease_its_quantity()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('admin.rebar.cutting-logs.store'), [
            'rebar_requirement_id' => $this->requirement->id,
            'quantity_cut' => 2,
            'date' => '2026-05-19',
            'bar_diameter' => 12,
            'original_length' => 8.00,
            'cut_length' => 6.00,
            'reused_offcut_id' => $this->offcut->id,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        // Check offcut quantity has decreased by 2
        $this->assertDatabaseHas('offcuts', [
            'id' => $this->offcut->id,
            'quantity' => 3,
            'status' => 'Available',
        ]);

        // Check cutting log has reused_offcut_id
        $this->assertDatabaseHas('rebar_cutting_logs', [
            'rebar_requirement_id' => $this->requirement->id,
            'reused_offcut_id' => $this->offcut->id,
            'original_length' => 8.00,
        ]);
    }

    /** @test */
    public function it_marks_offcut_as_used_when_quantity_reaches_zero()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('admin.rebar.cutting-logs.store'), [
            'rebar_requirement_id' => $this->requirement->id,
            'quantity_cut' => 5,
            'date' => '2026-05-19',
            'bar_diameter' => 12,
            'original_length' => 8.00,
            'cut_length' => 6.00,
            'reused_offcut_id' => $this->offcut->id,
        ]);

        $response->assertRedirect();

        // Check offcut status changes to Used
        $this->assertDatabaseHas('offcuts', [
            'id' => $this->offcut->id,
            'quantity' => 0,
            'status' => 'Used',
        ]);
    }

    /** @test */
    public function deleting_cutting_log_restores_reused_offcut_quantity()
    {
        $this->actingAs($this->user);

        $log = RebarCuttingLog::create([
            'rebar_requirement_id' => $this->requirement->id,
            'date' => '2026-05-19',
            'bar_diameter' => 12,
            'original_length' => 8.00,
            'cut_length' => 6.00,
            'remaining_length' => 2.00,
            'quantity_cut' => 2,
            'reused_offcut_id' => $this->offcut->id,
            'user_id' => $this->user->id,
            'site_id' => $this->site->id,
        ]);

        // Pretend we decreased the offcut in setup
        $this->offcut->quantity -= 2;
        $this->offcut->save();

        $response = $this->delete(route('admin.rebar.cutting-logs.destroy', $log));

        $response->assertRedirect();

        // Check offcut quantity is restored to 5
        $this->assertDatabaseHas('offcuts', [
            'id' => $this->offcut->id,
            'quantity' => 5,
            'status' => 'Available',
        ]);
    }
}
