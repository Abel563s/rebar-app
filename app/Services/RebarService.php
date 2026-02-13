<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RebarService
{
    /**
     * Generate a unique tracking ID for a Rebar Requirement.
     * Format: REB-YYYY-XXXXX
     */
    public function generateRequirementId(): string
    {
        return $this->generateId('REB');
    }

    /**
     * Generate a unique ID for an Off-cut.
     * Format: OFF-YYYY-XXXXX
     */
    public function generateOffcutId(): string
    {
        return $this->generateId('OFF');
    }

    /**
     * Generate a sequential ID based on type and year.
     * Ensures uniqueness and persistence even if records are deleted.
     */
    private function generateId(string $prefix): string
    {
        return DB::transaction(function () use ($prefix) {
            $year = Carbon::now()->year;

            // Attempt to retrieve the sequence record with a lock for update
            $sequence = DB::table('rebar_sequences')
                ->where('type', $prefix)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();

            if (!$sequence) {
                // Initialize sequence if it doesn't exist for this year
                DB::table('rebar_sequences')->insert([
                    'type' => $prefix,
                    'year' => $year,
                    'last_number' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $lastNumber = 0;
            } else {
                $lastNumber = $sequence->last_number;
            }

            $nextNumber = $lastNumber + 1;

            // Update the sequence
            DB::table('rebar_sequences')
                ->where('type', $prefix)
                ->where('year', $year)
                ->update([
                    'last_number' => $nextNumber,
                    'updated_at' => now()
                ]);

            // Format: PREFIX-YEAR-00001
            return sprintf('%s-%d-%05d', $prefix, $year, $nextNumber);
        });
    }
}
