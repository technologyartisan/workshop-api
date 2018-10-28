<?php

use Illuminate\Database\Seeder;
use App\Contact;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 30 ; $i++) { 
            $name=$faker->name;
            $picture=strtolower($name[0].'.png');
            
            Contact::create([
                'name'          => $name,
                'phone_number'  => $faker->phoneNumber,
                'picture'       => $picture
            ]);
        }
    }
}
