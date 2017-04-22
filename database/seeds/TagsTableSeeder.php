<?php

use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //delete tags table records
       DB::table('tags')->delete();
       //insert some preset records
       DB::table('tags')->insert(array(
           array('description'=>'dog'),
           array('description'=>'cat'),
           array('description'=>'bird'),
           array('description'=>'fish'),
           array('description'=>'exotic'),
           array('description'=>'others'),
           array('description'=>'trading'),
           array('description'=>'help'),
           array('description'=>'tutorial'),
        ));
    }
}
