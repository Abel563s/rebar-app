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

    /**
     * Calculate weight in KG based on diameter and length.
     * Formula: (D^2 * L) / 162
     */
    public function calculateWeight(int $diameter, float $lengthMt, int $quantity = 1): float
    {
        if ($diameter <= 0 || $lengthMt <= 0) return 0;
        return (($diameter * $diameter * $lengthMt) / 162) * $quantity;
    }

    /**
     * Determine if a rebar piece is considered wastage based on its diameter and length.
     * Thresholds provided:
     * 08 < 0.5m, 10 < 0.5m, 12 < 0.5m (implied), 14 < 1.2m, 16 < 1.2m, 18 < 1.2m (implied), 
     * 20 < 1.5m, 24 < 2.5m, 28 < 2.5m (implied), 32 < 3.0m
     */
    public function isWastage(int $diameter, float $lengthMt): bool
    {
        $thresholds = [
            8 => 0.5,
            10 => 0.5,
            12 => 0.5,
            14 => 1.2,
            16 => 1.2,
            18 => 1.2,
            20 => 1.5,
            24 => 2.5,
            28 => 2.5,
            32 => 3.0,
        ];

        $threshold = $thresholds[$diameter] ?? 0.3; // Default 0.3m if not specified
        return $lengthMt < $threshold;
    }
}
