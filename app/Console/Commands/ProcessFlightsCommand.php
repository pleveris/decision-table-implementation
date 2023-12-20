<?php

namespace App\Console\Commands;

use App\Exceptions\LogicException;
use App\Services\FlightClaimService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ProcessFlightsCommand extends Command
{
    protected $signature = 'process:flights {file}';
    protected $description = 'Process flights from a CSV file';

    public function handle()
    {
        $file = $this->argument('file');

        if (! File::exists($file)) {
            $this->error('The input file was not found!');
            return self::FAILURE;
        }

        $csvData = $this->readCsv($file);

        $this->info("Processing flights from $file");

        $flightClaimService = resolve(FlightClaimService::class);

        $results = [];

        try {
            foreach ($csvData as $row) {
                $country = trim($row[0]);
                $status = trim($row[1]);
                $details = (int)trim($row[2]);

                $claimable = $flightClaimService->isFlightClaimable($country, $status, $details);
                $results[] = [$country, $status, $details, $claimable ? 'Y' : 'N'];
            }
        } catch(LogicException $e) {
            $this->info($e->getMessage());
            return self::FAILURE;
        }

            $this->displayResults($results);

        return self::SUCCESS;
    }

    private function readCsv(string $file): array
    {
        return array_map('str_getcsv', file($file));
    }

    private function displayResults(array $results): void
    {
        $headers = ['Country', 'Status', 'Details', 'Claimable'];
        $this->table($headers, $results);
    }
}
