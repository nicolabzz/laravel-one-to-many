<?php

use App\Post;
use App\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PostSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $categories = Category::all('id')->all();
        for ($i = 0; $i < 100; $i++) {
            $title = $faker->words(rand(3, 7), true);
            // $loremImages = Storage::files('lorempicsum');
            // $img_path = Storage::put('uploads', $faker->randomElement($loremImages));

            Post::create([
                'category_id'   => $faker->randomElement($categories)->id,
                'slug'          => Post::getSlug($title),
                'title'         => $title,
                'image'         => 'https://picsum.photos/id/' . rand(0, 1000) . '/500/400',
                // 'uploaded_img'  => $img_path,
                'content'       => $faker->paragraphs(rand(1, 10), true),
                'excerpt'       => $faker->paragraph(),
            ]);
        }
    }
}
