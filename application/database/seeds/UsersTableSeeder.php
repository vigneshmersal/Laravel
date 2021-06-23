<?php

use App\ { User };
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		// laravel8
		User::factory(10)->create();

		# Admin seed
		$cities = collect(City::all()->modelKeys());
		factory(User::class, 1)->create([
			'email' => 'admin@doccure.com',
			'role' => 'admin',
			'salary' => rand(10000, 50000),
			'city_id' => $cities->random(),
		]);

		# Doctor seed
		factory(User::class, 1)->create(['role' => 'doctor'])->each(function ($user) {
			$this->doctorSeed($user);
		});

		# Seed array of data
		$data = [
			['Urology'],
		];
		foreach ($data as $test) {
			Model::create([
				'name' => $test[0]
			]);
		}

		# optimize seed by insert
		$bulk = [];
		for ($i=0; $i<50000; $i++) {
			$bulk[] = [
				'created_at' => now()->toDateTimeString(),
				'updated_at' => now()->toDateTimeString(),
			];
		}
		$chunks = array_chunk($bulk, $size=5000);
		foreach($chunks as $chunk) {
			Model::insert($chunk);
		}

		# run no of times
		Collection::times(3, function ($n) {
    		return factory(Category::class)->create(['number'=>$n]);
		});
	}

	// Doctor sub tables seed
	public function doctorSeed($user) {
		$user->doctor()->save(factory(Doctor::class)->make());
		return true;
	}
}
