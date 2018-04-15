<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('products')->insert([
            'id'         => null,
            'sku'        => "1001",
            'slug'       => "dreamweaver-cs4",
            'title'      => "Dreamweaver CS4",
            'author'     => "Janine Warner",
            'publisher'  => "PANEM",
            'price'      => 3900,
            'img_url'    => "/img/dreamweaver-cs4.jpg",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
        DB::table('products')->insert([
            'id'         => null,
            'sku'        => "1002",
            'slug'       => "javascript-kliens-oldalon",
            'title'      => "JavaScript kliens oldalon",
            'author'     => "Sikos László",
            'publisher'  => "BBS-INFO",
            'price'      => 2900,
            'img_url'    => "/img/javascript-kliens-oldalon.jpg",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
        DB::table('products')->insert([
            'id'         => null,
            'sku'        => "1003",
            'slug'       => "java",
            'title'      => "Java",
            'author'     => "Barry Burd",
            'publisher'  => "PANEM",
            'price'      => 3700,
            'img_url'    => "/img/java.jpg",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
        DB::table('products')->insert([
            'id'         => null,
            'sku'        => "1004",
            'slug'       => "csharp-2008",
            'title'      => "C# 2008",
            'author'     => "Stephen Randy Davis",
            'publisher'  => "PANEM",
            'price'      => 3700,
            'img_url'    => "/img/csharp-2008.jpg",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
        DB::table('products')->insert([
            'id'         => null,
            'sku'        => "1005",
            'slug'       => "az-ajax-alapjai",
            'title'      => "Az Ajax alapjai",
            'author'     => "Joshua Eichorn",
            'publisher'  => "PANEM",
            'price'      => 4500,
            'img_url'    => "/img/az-ajax-alapjai.jpg",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
        DB::table('products')->insert([
            'id'         => null,
            'sku'        => "1006",
            'slug'       => "algoritmusok",
            'title'      => "Algoritmusok",
            'author'     => "Ivanyos Gábor, Rónyai Lajos, Szabó Réka",
            'publisher'  => "TYPOTEX",
            'price'      => 3600,
            'img_url'    => "/img/algoritmusok.jpg",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);
    }
}
