<?php

namespace App\Console\Commands;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eldeeb:create-admin 
                            {--email= : The email of the admin}
                            {--name= : The name of the admin}
                            {--password= : The password (optional, prompted if omitted)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed roles & permissions and create a Super Admin user interactively';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('1. Seeding roles and permissions...');
        $this->call(RolesAndPermissionsSeeder::class);

        $this->info('2. Creating Super Admin User...');

        $name = $this->option('name') ?: $this->ask('Admin Name', 'Admin');
        $email = $this->option('email') ?: $this->ask('Admin Email', 'admin@eldeeb.com');

        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email address provided.');

            return self::FAILURE;
        }

        $password = $this->option('password');
        if (! $password) {
            $password = $this->secret('Admin Password (min 8 characters)');
            $confirmPassword = $this->secret('Confirm Password');

            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match.');

                return self::FAILURE;
            }
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $user->assignRole($superAdminRole);
        }

        $this->info("Super Admin [{$user->email}] created successfully!");
        $this->info('You can now login at /admin/login.');

        return self::SUCCESS;
    }
}
