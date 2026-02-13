<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RebarRequirement;
use App\Models\RebarCuttingLog;
use App\Models\Offcut;
use App\Models\User;
use Carbon\Carbon;

class ProjectPopulatorSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::where('role', 'admin')->first()->id ?? 1;

        // 1. Create a variety of Requirements
        $elements = [
            ['element' => 'F1 Footings', 'dia' => 16, 'len' => 1800, 'qty' => 40],
            ['element' => 'C1 Columns', 'dia' => 25, 'len' => 3850, 'qty' => 24],
            ['element' => 'B1 Main Beams', 'dia' => 20, 'len' => 5200, 'qty' => 18],
            ['element' => 'S1 Slab Bottom', 'dia' => 10, 'len' => 4000, 'qty' => 120],
            ['element' => 'S1 Slab Top', 'dia' => 10, 'len' => 2500, 'qty' => 100],
            ['element' => 'W1 Retaining Wall', 'dia' => 12, 'len' => 3200, 'qty' => 60],
            ['element' => 'L1 Lintels', 'dia' => 10, 'len' => 1500, 'qty' => 30],
        ];

        foreach ($elements as $el) {
            RebarRequirement::create([
                'structural_element' => $el['element'],
                'bar_diameter' => $el['dia'],
                'required_length' => $el['len'],
                'quantity' => $el['qty'],
                'drawing_reference' => 'DWG-' . rand(100, 999),
                'user_id' => $userId,
            ]);
        }

        // 2. Generate cutting logs over the last 6 months for the trend chart
        $requirements = RebarRequirement::all();

        for ($i = 0; $i < 150; $i++) {
            $req = $requirements->random();
            $date = Carbon::now()->subDays(rand(0, 180));

            $log = RebarCuttingLog::create([
                'rebar_requirement_id' => $req->id,
                'date' => $date,
                'bar_diameter' => $req->bar_diameter,
                'original_length' => 12000, // standard length
                'cut_length' => $req->required_length,
                'user_id' => $userId,
                'used_for' => 'Automated Batch Fabrication',
            ]);

            // Randomly create offcuts or scrap
            $rem = 12000 - $req->required_length;
            if ($rem > 500) {
                $status = rand(0, 5) > 1 ? 'Available' : 'Used';
                if ($i % 10 == 0)
                    $status = 'Scrap';

                $offcut = Offcut::create([
                    'bar_diameter' => $req->bar_diameter,
                    'length' => $rem,
                    'quantity' => 1,
                    'storage_location' => 'Rack ' . chr(rand(65, 70)) . '-' . rand(1, 10),
                    'status' => $status,
                    'remarks' => 'Auto-generated during simulation',
                    'created_at' => $date,
                ]);

                if ($status == 'Used') {
                    $log->offcut_id = $offcut->id;
                    $log->save();
                }
            }
        }
    }
}
