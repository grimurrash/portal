<?php

namespace App\Jobs;

use App\Contracts\Employee\EmployeeServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $fileName,
        private readonly string $sheetName,
    )
    {
    }

    public function handle(EmployeeServiceInterface $employeeService): void
    {
        $employeeService->import($this->fileName, $this->sheetName);
    }
}
