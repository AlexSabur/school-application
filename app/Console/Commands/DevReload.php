<?php

namespace App\Console\Commands;

use Database\Seeders\FakeStudentSeeder;
use Illuminate\Console\Command;

class DevReload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('db:wipe');

        $this->call('migrate');

        $this->call('db:seed');

        $this->call('db:seed', [ '--class' => FakeStudentSeeder::class ]);

        return 0;
    }
}
