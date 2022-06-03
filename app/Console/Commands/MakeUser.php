<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {username?} {email?} {password?}';

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
        try {
            User::create([
                'name' => $this->getUsername(),
                'email' => $this->getEmail(),
                'password' => Hash::make($this->getPassword()),
            ]);

            return 0;
        } catch (\Throwable $th) {
            $this->error($th->getMessage());

            return 1;
        }
    }

    protected function getUsername()
    {
        if ($this->hasArgument('username')) {
            return $this->argument('username');
        }

        return $this->ask('username');
    }

    protected function getEmail()
    {
        if ($this->hasArgument('email')) {
            return $this->argument('email');
        }

        return $this->ask('email');
    }

    protected function getPassword()
    {
        if ($this->hasArgument('password')) {
            return $this->argument('password');
        }

        return $this->secret('password');
    }
}
