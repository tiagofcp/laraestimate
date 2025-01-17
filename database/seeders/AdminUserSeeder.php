<?php
namespace Database\Seeders;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          User::factory(1)->create([
            'email' => 'admin@admin.com'
        ]);
    }
}
