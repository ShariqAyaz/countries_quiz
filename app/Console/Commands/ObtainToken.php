<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ObtainToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:obtain-token {email} {token_name=api-token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just Obtain Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $tokenName = $this->argument('token_name');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1; 
        }

        $token = $user->createToken($tokenName)->plainTextToken;

        $this->info("Token generated successfully for '{$email}':");
        $this->line($token);

        return 0;
    }
}