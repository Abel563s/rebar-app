<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RebarRequirement;
use App\Models\Offcut;
use App\Models\RebarCuttingLog;
use Carbon\Carbon;

class RebarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Require auth user for ID generation service dependency if needed, 
        // but the service works with sequences table.
        // Let's create an admin user context if strictly required, but it's not.

        $userId = \App\Models\User::first()->id ?? 1;

        // 1. Create some Rebar Requirements
        $requirements = [
            [
                'structural_element' => 'C1 Columns',
                'bar_diameter' => 25,
                'required_length' => 3850,
                'quantity' => 12,
                'drawing_reference' => 'ST-04 Rev.1',
                'remarks' => 'Ground floor columns',
                'user_id' => $userId,
            ],
            [
                'structural_element' => 'B2 Beams',
                'bar_diameter' => 16,
                'required_length' => 5200,
                'quantity' => 20,
                'drawing_reference' => 'ST-06 Rev.0',
                'user_id' => $userId,
            ],
            [
                'structural_element' => 'S1 Slab Top',
                'bar_diameter' => 10,
                'required_length' => 4500,
                'quantity' => 50,
                'drawing_reference' => 'ST-02',
                'user_id' => $userId,
            ],
            [
                'structural_element' => 'F1 Footing',
                'bar_diameter' => 16,
                'required_length' => 1800,
                'quantity' => 30,
                'drawing_reference' => 'ST-01',
                'user_id' => $userId,
            ],
        ];

        foreach ($requirements as $req) {
            RebarRequirement::create($req);
        }

        // 2. Creates some Offcuts (Pre-existing stock)
        $offcuts = [
            [
                'bar_diameter' => 25,
                'length' => 1500,
                'quantity' => 5,
                'storage_location' => 'Rack A-1',
                'status' => 'Available',
                'remarks' => 'Leftover from previous project',
            ],
            [
                'bar_diameter' => 16,
                'length' => 2400,
                'quantity' => 2,
                'storage_location' => 'Rack B-2',
                'status' => 'Available',
            ],
            [
                'bar_diameter' => 10,
                'length' => 800,
                'quantity' => 10,
                'storage_location' => 'Bin C',
                'status' => 'Scrap',
            ],
        ];

        foreach ($offcuts as $off) {
            Offcut::create($off);
        }

        // 3. Log some cutting.
        // Let's take the first requirement (C1 Columns, 25mm, 3850mm length)
        $req1 = RebarRequirement::where('structural_element', 'C1 Columns')->first();

        if ($req1) {
            // Simulate cutting 1 bar from a 12m stock
            // 12000 - 3850 = 8150 offcut
            $log1 = RebarCuttingLog::create([
                'rebar_requirement_id' => $req1->id,
                'date' => Carbon::now()->subDays(2),
                'bar_diameter' => 25,
                'original_length' => 12000,
                'cut_length' => 3850,
                // remaining_length calc in boot model
                'user_id' => $userId,
                'used_for' => 'Sample initial cut',
            ]);

            // Create the resulting offcut
            if ($log1->remaining_length > 300) {
                $newOffcut = Offcut::create([
                    'bar_diameter' => 25,
                    'length' => $log1->remaining_length,
                    'quantity' => 1,
                    'storage_location' => 'Generated Area',
                    'status' => 'Available',
                    'remarks' => 'From C1 Columns cut',
                ]);
                $log1->offcut_id = $newOffcut->id;
                $log1->save();
            }
        }
    }
}
