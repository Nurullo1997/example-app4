<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Post::factory()->count(20)->create();





      // Post::create([
      //      'user_id' => 1,
       //     'title' => 'sarlavha',
      //      'short_content' =>'qisqa mazmun',
      //      'content' => 'misol kontent',
       //     'photo' =>  null,
      // ]);

    
    
    }





}
