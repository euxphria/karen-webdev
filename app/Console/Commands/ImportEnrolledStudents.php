<?php

namespace App\Console\Commands;

use App\Models\EnrolledStudent;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:import-enrolled-students {path}')]
#[Description('Import enrolled students from a CSV file')]
class ImportEnrolledStudents extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path');

        if (!file_exists($path)) {
            $this->error("File not found: {$path}");
            return 1;
        }

        $handle = fopen($path, 'r');
        $header = fgetcsv($handle); // expects: email,name,student_id

        $count = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            EnrolledStudent::updateOrCreate(
                ['email' => trim($data['email'])],
                [
                    'name'       => $data['name'] ?? null,
                    'student_id' => $data['student_id'] ?? null,
                    'program'    => $data['program'] ?? null,
                    'year'       => $data['year'] ?? null,
                ]
            );

            $count++;
        }

        fclose($handle);

        $this->info("Imported {$count} students.");
        return 0;
    }
}