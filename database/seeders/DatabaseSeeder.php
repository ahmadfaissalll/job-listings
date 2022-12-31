<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\User::factory(5)->create();

    Listing::factory(20)->create();
    
    Listing::factory(18)->create([
      'user_id' => 1,
    ]);

    Listing::factory(18)->create([
      'user_id' => 3,
    ]);
  }
}
