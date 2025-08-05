<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'make:admin {name} {email} {password}';
    protected $description = 'Create a new admin user';

    public function handle()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
            'role' => 'admin',
        ]);
        $this->info('Admin user created: ' . $user->email);
    }
}
