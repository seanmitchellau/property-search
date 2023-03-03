<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new (admin) user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Full name');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');
    
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    
        $this->info("The user was added and may now login with their email address: $email");

        return true;
    }
}
