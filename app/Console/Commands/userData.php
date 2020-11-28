<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userData extends Command
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
    protected $description = 'add user record into database';

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
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email id?');
        $password = $this->secret('What is the password?');

        $data = new User();
        $data->name = $name;
        $data->email = $email;
        $data->email_verified_at = now();
        $data->password = Hash::make($password);
        $data->email_verified_at = now();
        $data->save();
        $this->info('User register successfully');
    }
}
