<?php

namespace App\Console\Commands;

use App\Models\Team;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    protected $description = 'Create a new user with a personal team';

    protected $signature = 'app:create-user
                            {--name= : The name of the user}
                            {--email= : A valid and unique email address}
                            {--password= : The password for the user (min. 8 characters)}
                            {--team= : The name of the personal team (defaults to "<Name>\'s Team")}';

    public function handle(): int
    {
        $name = $this->option('name') ?? text(
            label: 'Name',
            required: true,
        );

        $email = $this->option('email') ?? text(
            label: 'Email address',
            required: true,
            validate: fn (string $email): ?string => match (true) {
                ! filter_var($email, FILTER_VALIDATE_EMAIL) => 'The email address must be valid.',
                User::where('email', $email)->exists() => 'A user with this email address already exists.',
                default => null,
            },
        );

        $plainPassword = $this->option('password') ?? password(
            label: 'Password',
            required: true,
        );

        $teamName = $this->option('team') ?? explode(' ', $name, 2)[0]."'s Team";

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $plainPassword,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::default()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return static::INVALID;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($plainPassword),
        ]);

        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => $teamName,
            'personal_team' => true,
        ]));

        $loginUrl = route('filament.app.auth.login');

        $this->components->info("Success! {$user->email} may now log in at {$loginUrl}");

        return static::SUCCESS;
    }
}
