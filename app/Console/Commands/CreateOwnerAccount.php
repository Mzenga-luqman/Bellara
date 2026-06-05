<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateOwnerAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owner:create
        {--name= : Owner full name}
        {--email= : Owner email address}
        {--password= : Owner password (omit to be prompted securely)}
        {--force : Allow creating owner when users already exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the first owner account for a fresh Bellara installation';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (User::query()->exists() && ! $this->option('force')) {
            $this->error('An account already exists. This command is one-time by default.');
            $this->line('Use --force only if you intentionally want to add another owner account.');

            return self::FAILURE;
        }

        $name = trim((string) ($this->option('name') ?: $this->ask('Owner name')));
        $email = strtolower(trim((string) ($this->option('email') ?: $this->ask('Owner email'))));

        $passwordOption = $this->option('password');
        if (is_string($passwordOption) && $passwordOption !== '') {
            $password = $passwordOption;
        } else {
            $password = (string) $this->secret('Owner password (input hidden)');
            $confirmPassword = (string) $this->secret('Confirm password');

            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match.');

                return self::FAILURE;
            }
        }

        $validator = Validator::make(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', Password::defaults()],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
        ]);

        $user->forceFill([
            'is_admin' => true,
        ])->save();

        $this->info('Owner account created successfully.');
        $this->line('ID: '.$user->id);
        $this->line('Email: '.$user->email);

        return self::SUCCESS;
    }
}
