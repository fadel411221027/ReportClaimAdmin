<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $winda = User::create([
            'name' => 'winda',
            'username' => 'winda',
            'email' => 'winda@gmail.com',
            'password' => bcrypt('winda')
        ]);
        $winda->assignRole('PIC');

        $suwakar = User::create([
            'name' => 'suwakar',
            'username' => 'suwakar',
            'email' => 'suwakar@gmail.com',
            'password' => bcrypt('suwakar')
        ]);
        $suwakar->assignRole('Leader');

        $risma = User::create([
            'name' => 'risma',
            'username' => 'risma',
            'email' => 'risma@gmail.com',
            'password' => bcrypt('risma')
        ]);
        $risma->assignRole('TeamAdmin');

        $hesti = User::create([
            'name' => 'hesti',
            'username' => 'hesti',
            'email' => 'hesti@gmail.com',
            'password' => bcrypt('hesti')
        ]);
        $hesti->assignRole('TeamAdmin');

        $elida = User::create([
            'name' => 'elida',
            'username' => 'elida',
            'email' => 'elida@gmail.com',
            'password' => bcrypt('elida')
        ]);
        $elida->assignRole('TeamAdmin');
    
        $dwi = User::create([
            'name' => 'dwi',
            'username' => 'dwi',
            'email' => 'dwi@gmail.com',
            'password' => bcrypt('dwi')
        ]);
        $dwi->assignRole('TeamAdmin');
    
        $firman = User::create([
            'name' => 'firman',
            'username' => 'firman',
            'email' => 'firman@gmail.com',
            'password' => bcrypt('firman')
        ]);
        $firman->assignRole('TeamAdmin');
    
        $fahmi = User::create([
            'name' => 'fahmi',
            'username' => 'fahmi',
            'email' => 'fahmi@gmail.com',
            'password' => bcrypt('fahmi')
        ]);
        $fahmi->assignRole('TeamAdmin');
    
        $tomy = User::create([
            'name' => 'tomy',
            'username' => 'tomy',
            'email' => 'tomy@gmail.com',
            'password' => bcrypt('tomy')
        ]);
        $tomy->assignRole('TeamAdmin');
    
        $edo = User::create([
            'name' => 'edo',
            'username' => 'edo',
            'email' => 'edo@gmail.com',
            'password' => bcrypt('edo')
        ]);
        $edo->assignRole('TeamAdmin');
    
        $fadel = User::create([
            'name' => 'fadel',
            'username' => 'fadel',
            'email' => 'fadel@gmail.com',
            'password' => bcrypt('fadel')
        ]);
        $fadel->assignRole('TeamAdmin');

        $sri = User::create([
            'name' => 'sri',
            'username' => 'sri',
            'email' => 'sri@gmail.com',
            'password' => bcrypt('sri')
        ]);
        $sri->assignRole('TeamAdmin');

        $dev = User::create([
            'name' => 'dev',
            'username' => 'dev',
            'email' => 'dev@gmail.com',
            'password' => bcrypt('dev')
        ]);
        $dev->assignRole('dev');


        // $faker = Faker::create('id_ID');
        // for ($i = 1; $i <= 9; $i++) {
        //     $user = User::create([
        //         'name' => $faker->name,
        //         'username' => $faker->unique()->userName,
        //         'email' => $faker->unique()->safeEmail,
        //         'password' => bcrypt('TeamAdmin')
        //     ]);
        //     $user->assignRole('TeamAdmin');
        // }

    }
}
