<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class CreateAdminUser extends Command
{
    protected $signature = 'luxora:create-admin';

    protected $description = 'Create or promote a trusted Luxora administrator account';

    public function handle(): int
    {
        $this->info('Luxora Administrator Setup');
        $this->line('--------------------------');

        $email = Str::lower(trim((string) $this->ask('Administrator email address')));

        $validator = Validator::make(
            ['email' => $email],
            ['email' => ['required', 'email', 'max:255']]
        );

        if ($validator->fails()) {
            $this->error($validator->errors()->first('email'));

            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $this->warn("An account already exists for {$email}.");

            if ($user->isAdmin()) {
                $this->info('This account already has the administrator role.');

                return self::SUCCESS;
            }

            if (! $this->confirm(
                'Promote this existing account to administrator?',
                false
            )) {
                $this->comment('No changes were made.');

                return self::SUCCESS;
            }

            $user->forceFill(['role' => 'admin'])->save();

            $this->info('The existing account is now an administrator.');
            $this->warn('Its password has not been changed.');

            return self::SUCCESS;
        }

        $name = trim((string) $this->ask('Administrator full name'));

        if ($name === '' || mb_strlen($name) > 255) {
            $this->error('Enter a valid name of no more than 255 characters.');

            return self::FAILURE;
        }

        $password = (string) $this->secret('Create a strong administrator password');
        $passwordConfirmation = (string) $this->secret('Confirm administrator password');

        if ($password !== $passwordConfirmation) {
            $this->error('The passwords do not match.');

            return self::FAILURE;
        }

        $passwordValidator = Validator::make(
            ['password' => $password],
            ['password' => ['required', Password::min(12)->mixedCase()->numbers()->symbols()]]
        );

        if ($passwordValidator->fails()) {
            $this->error($passwordValidator->errors()->first('password'));

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ])->forceFill([
            'role' => 'admin',
        ])->save();

        $this->newLine();
        $this->info('Administrator account created successfully.');
        $this->line("Email: {$email}");
        $this->comment('Keep your password private.');

        return self::SUCCESS;
    }
}
