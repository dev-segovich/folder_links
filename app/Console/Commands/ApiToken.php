<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ApiToken extends Command
{
    protected $signature = 'api:token {email : Email of the user the token belongs to} {--name=api : A label for the token}';

    protected $description = 'Create a Sanctum API token for a user (shown once)';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error("No existe un usuario con el email {$this->argument('email')}.");

            return self::FAILURE;
        }

        $token = $user->createToken($this->option('name'))->plainTextToken;

        $this->info("Token creado para {$user->name} ({$user->role}).");
        $this->newLine();
        $this->line('  '.$token);
        $this->newLine();
        $this->warn('Guárdalo ahora: no se volverá a mostrar.');

        return self::SUCCESS;
    }
}
