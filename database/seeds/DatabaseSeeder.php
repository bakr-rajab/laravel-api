<?php

use App\User;
use App\Product;
use App\Transaction;
use App\Category;
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
        // $this->call(UsersTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Product::truncate();
        Category::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $usersQ=20;
        $categoriesQ=30;
        $productsQ=30;
        $transactionsQ=10;

        factory(User::class,$usersQ)->create();
        factory(Category::class,$categoriesQ)->create();
        factory(Product::class,$productsQ)->create()->each(
            function ($product){
                $categories= Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );

        factory(Transaction::class,$transactionsQ)->create();

    }
}
