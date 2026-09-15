<?php

namespace App\Imports;

use App\Models\Offcut;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Services\RebarService;

class OffcutImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        $service = app(RebarService::class);

        $data = [
            'offcut_code' => $row['offcut_code'] ?? $service->generateOffcutId(),
            'site_id' => $row['site_id'] ?? null,
            'bar_diameter' => (int) $row['bar_diameter'],
            'length' => (int) $row['length'],
            'quantity' => (int) ($row['quantity'] ?? 1),
            'storage_location' => $row['storage_location'] ?? null,
            'status' => $row['status'] ?? 'Available',
            'remarks' => $row['remarks'] ?? null,
            'user_id' => $this->userId,
        ];

        return new Offcut($data);
    }

    public function rules(): array
    {
        return [
            'offcut_code' => 'nullable|string|max:255|unique:offcuts,offcut_code',
            'site_id' => 'nullable|exists:project_sites,id',
            'bar_diameter' => 'required|integer|min:1',
            'length' => 'required|integer|min:1',
            'quantity' => 'nullable|integer|min:1',
            'storage_location' => 'nullable|string|max:255',
            'status' => 'nullable|in:Available,Used,Scrap',
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
