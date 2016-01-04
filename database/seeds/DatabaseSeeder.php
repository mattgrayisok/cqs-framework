<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (App::environment() == 'testing') {

            //Run testing seeders
            $this->call(CountriesSeeder::class);
            $this->call(OAuthSeeder::class);
            $this->call(UserRoleSeeder::class);

        } else {

            //Run static data seeders
            $this->emptyTables();
            $this->call(CountriesSeeder::class);
            $this->call(OAuthSeeder::class);
            $this->call(UserRoleSeeder::class);

        }
        
        Model::reguard();
    }

    private function emptyTables(){

        if( substr_count( get_class(DB::connection()), 'MySql') > 0 ) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($tableNames as $name) {
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }

        if( substr_count( get_class(DB::connection()), 'MySql') > 0 ) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

    }
}
