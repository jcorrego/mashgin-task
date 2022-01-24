<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $category = Category::factory()->create([
             'name' => 'Bakery',
             'image_id' => 'f3fbf57b118fa9',
         ]);
        Item::factory()->create([
            'name' => 'Bagel',
            'price' => 2.0,
            'category_id' => $category->id,
            'image_id' => '293202f9d9f7f4',
        ]);
        Item::factory()->create([
            'name' => 'Croissant',
            'price' => 1.0,
            'category_id' => $category->id,
            'image_id' => '808916fd5ddf96',
        ]);
        Item::factory()->create([
            'name' => 'Muffin',
            'price' => 1.25,
            'category_id' => $category->id,
            'image_id' => '95d02a230fe050',
        ]);
        Item::factory()->create([
            'name' => 'Toast / Bread',
            'price' => 1,
            'category_id' => $category->id,
            'image_id' => '23f95765b967ff',
        ]);
        Item::factory()->create([
            'name' => 'English Muffin',
            'price' => 2.5,
            'category_id' => $category->id,
            'image_id' => '5650be5d48a99b',
        ]);

         $category = Category::factory()->create([
             'name' => 'Entrees',
             'image_id' => 'b271afbefdc554',
         ]);
        Item::factory()->create([
            'name' => 'Pasta Bar',
            'price' => 12.99,
            'category_id' => $category->id,
            'image_id' => 'bd237a0c0d19ef',
        ]);
        Item::factory()->create([
            'name' => 'Mediterranean Entree',
            'price' => 10.99,
            'category_id' => $category->id,
            'image_id' => '3e1bd1342800f7',
        ]);
        Item::factory()->create([
            'name' => 'Indian Entree',
            'price' => 11.95,
            'category_id' => $category->id,
            'image_id' => '72589c4c990f97',
        ]);

        $category = Category::factory()->create([
             'name' => 'Drinks',
             'image_id' => 'eba73b2361fae3',
         ]);
        Item::factory()->create([
            'name' => 'Small Drink',
            'price' => 0.75,
            'category_id' => $category->id,
            'image_id' => '70c2a6247e7b58',
        ]);
        Item::factory()->create([
            'name' => 'Medium Drink',
            'price' => 1.5,
            'category_id' => $category->id,
            'image_id' => 'dba0fc03da30ca',
        ]);
        Item::factory()->create([
            'name' => 'Large Drink',
            'price' => 2,
            'category_id' => $category->id,
            'image_id' => 'ffc9bf61e441cd',
        ]);



    }
}
