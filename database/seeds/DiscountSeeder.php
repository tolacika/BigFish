<?php

use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('discounts')->insert([
            'id'               => null,
            'sku'              => "101",
            'discount_type'    => "percent",
            'discount_amount'  => "10",
            'target_type'      => "single",
            'target_reference' => "1006",
            'active'           => 1,
            'valid_from'       => date("Y-m-d H:i:s", strtotime("-2 weeks")),
            'valid_to'         => date("Y-m-d H:i:s", strtotime("+2 weeks")),
            'created_at'       => date("Y-m-d H:i:s"),
            'updated_at'       => date("Y-m-d H:i:s"),
            'deleted_at'       => null,
        ]);
        DB::table('discounts')->insert([
            'id'               => null,
            'sku'              => "102",
            'discount_type'    => "fix",
            'discount_amount'  => "500",
            'target_type'      => "single",
            'target_reference' => "1002",
            'active'           => 1,
            'valid_from'       => date("Y-m-d H:i:s", strtotime("-2 weeks")),
            'valid_to'         => date("Y-m-d H:i:s", strtotime("+2 weeks")),
            'created_at'       => date("Y-m-d H:i:s"),
            'updated_at'       => date("Y-m-d H:i:s"),
            'deleted_at'       => null,
        ]);
        DB::table('discounts')->insert([
            'id'               => null,
            'sku'              => "103",
            'discount_type'    => "2+1",
            'discount_amount'  => null,
            'target_type'      => "publisher",
            'target_reference' => "PANEM",
            'active'           => 1,
            'valid_from'       => date("Y-m-d H:i:s", strtotime("-2 weeks")),
            'valid_to'         => date("Y-m-d H:i:s", strtotime("+2 weeks")),
            'created_at'       => date("Y-m-d H:i:s"),
            'updated_at'       => date("Y-m-d H:i:s"),
            'deleted_at'       => null,
        ]);
    }
}
