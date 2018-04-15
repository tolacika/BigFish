<?php
/**
 * Created by PhpStorm.
 * User: Tolacika
 * Date: 2018. 04. 15.
 * Time: 14:16
 */

namespace App;

use App\Models\Product;

/**
 * Class CartItem
 * @package App
 *
 * @property int productId
 * @property Product product
 * @property int count
 */
class CartItem extends stdObject {
    public function __construct($pid, $count) {
        $this->productId = $pid;
        $this->product = Product::find($pid);
        $this->count = $count;
    }
}