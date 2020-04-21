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
		// Admin seed
		factory(User::class, 1)->create([
			'email' => 'superadmin@doccure.com',
			'role' => 'admin'
		]);

		// Doctor seed
		factory(User::class, 1)->create([ 'email' => 'doctor@doccure.com','role' => 'doctor' ])
			->each(function ($user) {
				$this->doctorSeed($user);
			}
		);

		// Seed array of data
		$data = [
			['Urology', 'specialities-01.png'],
		];

		foreach ($data as $test) {
			$speciality = Speciality::create([
				'name' => $test[0],
				'image' => $test[1]
			]);
		}
	}

	// Doctor sub tables seed
	public function doctorSeed($user) {
		$user->doctor()->save(factory(Doctor::class)->make());
		return true;
	}
}
