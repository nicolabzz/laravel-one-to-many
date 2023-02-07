<?php

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 100; $i++) {
            // $title = $faker->words(rand(3, 7), true);
            $title = 'Ciao a Tutti';
            Post::create([
                'slug'      => Post::getSlug($title),
                'title'     => $title,
                'image'     => 'https://picsum.photos/id/' . rand(0, 1000) . '/500/400',
                'content'   => $faker->paragraphs(rand(1, 10), true),
                'excerpt'   => $faker->paragraph(),
            ]);
        }
    }
}
