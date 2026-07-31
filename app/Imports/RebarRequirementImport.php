<?php

namespace App\Imports;

use App\Models\RebarRequirement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Services\RebarService;

class RebarRequirementImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    protected $siteId;
    protected $userId;

    public function __construct($siteId = null, $userId = null)
    {
        $this->siteId = $siteId;
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $service = app(RebarService::class);

        $barDiameter = (int) $row['bar_diameter'];
        $requiredLength = (float) $row['required_length'];
        $quantity = (int) $row['quantity'];

        $data = [
            'tracking_id' => $service->generateRequirementId(),
            'site_id' => $this->siteId ?? $row['site_id'],
            'structural_element' => $row['structural_element'],
            'bar_diameter' => $barDiameter,
            'steel_grade' => (string) $row['steel_grade'],
            'required_length' => $requiredLength,
            'total_length' => $requiredLength * $quantity,
            'quantity' => $quantity,
            'weight_kg' => $service->calculateWeight($barDiameter, $requiredLength, $quantity),
            'user_id' => $this->userId,
            'drawing_reference' => $row['drawing_reference'] ?? null,
            'remarks' => $row['remarks'] ?? null,
        ];

        return new RebarRequirement($data);
    }

    public function rules(): array
    {
        return [
            'site_id' => 'required|exists:project_sites,id',
            'structural_element' => 'required|string|max:255',
            'bar_diameter' => 'required|integer|min:1',
            'steel_grade' => 'required|in:300,400,500,600',
            'required_length' => 'required|numeric|min:0.001',
            'quantity' => 'required|integer|min:1',
            'drawing_reference' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ];
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
