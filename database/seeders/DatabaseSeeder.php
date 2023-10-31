<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            
        ]);

        if (config('app.env') === 'local') {
            $this->call([

            ]);

            if (User::count() <= 0) {
                User::create([
                    'firstname' => 'Mr',
                    'lastname' => 'Admin',
                    'email' => 'admin@dogger.com',
                    'password' => 'Pass1234'
                ]);
            }
        }
    }
}
