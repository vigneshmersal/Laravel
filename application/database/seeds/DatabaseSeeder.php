<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * php artisan db:seed --class=CountrysTableSeeder
     * @return void
     */
    public function run()
    {
    	$this->command->info("Welcome to Database Seeder!\n");

    	$this->TruncateTable("App\User");
    	$this->CallSeeder("UsersTableSeeder");
    }

    private function CallSeeder($table)
	{
		// if ($this->command->confirm( "Confirm To Seed $table" )) {
			$this->call($table);
			$this->command->warn($table." Seeder Success\n");
		// }
	}

	private function TruncateTable($table)
	{
        Model::unguard();

		// if ($this->command->confirm( "Confirm To Truncate $table" )) {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Schema::disableForeignKeyConstraints();
			$table::truncate();
			DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Schema::enableForeignKeyConstraints();

			$this->command->warn($table." Truncated");
		// }
	}
}
