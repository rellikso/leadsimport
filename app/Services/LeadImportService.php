<?php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Http\UploadedFile;

class LeadImportService
{
    private const BATCH_SIZE = 1000;

    private const EXPECTED_HEADERS = [
        'external_id',
        'created_at',
        'first_name',
        'last_name',
        'phone',
        'email',
        'city',
        'source',
        'utm_campaign',
        'product',
        'budget_uah',
        'status',
        'manager',
        'comment',
        'next_contact_at',
    ];

    public function import(UploadedFile $file): array
    {
        $startedAt = microtime(true);

        $handle = fopen($file->getRealPath(), 'rb');

        if ($handle === false) {
            throw new \RuntimeException('Unable to open import file.');
        }

        try {
            $headers = fgetcsv($handle);

            if ($headers === false) {
                throw new \RuntimeException('The import file is empty.');
            }

            $headers = array_map('trim', $headers);

            if ($headers !== self::EXPECTED_HEADERS) {
                throw new \RuntimeException('Invalid CSV header.');
            }

            $batch = [];
            $processed = 0;
            $inserted = 0;

            while (($row = fgetcsv($handle)) !== false) {
                if ($row === [null]) {
                    continue;
                }

                $data = $this->mapRow($headers, $row);

                $batch[] = $data;
                $processed++;

                if (count($batch) >= self::BATCH_SIZE) {
                    Lead::query()->insert($batch);

                    $inserted += count($batch);
                    $batch = [];
                }
            }

            if ($batch !== []) {
                Lead::query()->insert($batch);
                $inserted += count($batch);
            }
        } finally {
            fclose($handle);
        }

        return [
            'processed' => $processed,
            'inserted' => $inserted,
            'errors' => 0,
            'duration' => round(microtime(true) - $startedAt, 3),
        ];
    }

    private function mapRow(array $headers, array $row): array
    {
        $data = array_combine($headers, $row);

        if ($data === false) {
            throw new \RuntimeException('Invalid CSV row.');
        }

        $budget = $data['budget_uah'] ?? null;

        if ($budget !== null && $budget !== '') {
            $budget = str_replace(["\u{00A0}", ' '], '', $budget);
            $budget = (int) $budget;
        } else {
            $budget = null;
        }

        return [
            'external_id' => $data['external_id'],
            'created_at' => $data['created_at'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'city' => $data['city'],
            'source' => $data['source'],
            'utm_campaign' => $data['utm_campaign'] ?: null,
            'product' => $data['product'],
            'budget_uah' => $budget,
            'status' => $data['status'],
            'manager' => $data['manager'] ?: null,
            'comment' => $data['comment'] ?: null,
            'next_contact_at' => $data['next_contact_at'] ?: null,
        ];
    }
}
