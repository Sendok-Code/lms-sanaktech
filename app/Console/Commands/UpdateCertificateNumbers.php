<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use Illuminate\Console\Command;

class UpdateCertificateNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificates:update-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update certificate numbers for existing certificates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating certificate numbers...');

        $certificates = Certificate::whereNull('certificate_number')
            ->orWhere('certificate_number', '')
            ->get();

        if ($certificates->isEmpty()) {
            $this->info('No certificates to update.');
            return 0;
        }

        $bar = $this->output->createProgressBar($certificates->count());
        $bar->start();

        foreach ($certificates as $certificate) {
            $certificate->certificate_number = Certificate::generateCertificateNumber();
            $certificate->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully updated {$certificates->count()} certificate(s)!");

        return 0;
    }
}
