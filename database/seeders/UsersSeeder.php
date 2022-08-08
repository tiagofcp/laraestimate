<?php
namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(app()->environment() === 'local') {
            $this->call(AdminUserSeeder::class);
        }
    }
}
