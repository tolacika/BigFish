<?php
/**
 * Created by PhpStorm.
 * User: Tolacika
 * Date: 2018. 04. 15.
 * Time: 14:09
 */

namespace App;


class Cart {

    /** @var CartItem[] */
    private $items = [];
    private static $_instance = null;

    private function __construct() {
        if (session()->has('cart')) {
            $cart = session('cart', []);
            foreach ($cart as $item) {
                $this->items[] = new CartItem($item['pid'], $item['count']);
            }
        }
    }

    /**
     * @return Cart
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Cart();
        }
        return self::$_instance;
    }

    public function getCount() {
        $count = 0;
        foreach ($this->items as $k => $item) {
            $count += $item->count;
        }
        return $count;
    }

    public function addToCart($pid, $count) {
        $found = false;
        foreach ($this->items as $k => $item) {
            if ($item->productId == $pid) {
                $found = true;
                $this->items[$k]->count += $count;
            }
        }
        if (!$found) {
            $this->items[] = new CartItem($pid, $count);
        }
        $this->save();
    }

    public function updateCartItem($pid, $count) {
        $found = false;
        foreach ($this->items as $k => $item) {
            if ($item->productId == $pid) {
                $found = true;
                $this->items[$k]->count = $count;
            }
        }
        if (!$found) {
            $this->items[] = new CartItem($pid, $count);
        }
        $this->save();
    }

    public function removeFromCart($pid) {
        foreach ($this->items as $k => $item) {
            if ($item->productId == $pid) {
                $this->items[$k]->count = 0;
            }
        }
        $this->save();
    }

    public function save() {
        $sessArry = [];
        foreach ($this->items as $item) {
            if ($item->count > 0) {
                $sessArry[] = ['pid' => $item->productId, 'count' => $item->count];
            }
        }
        session(['cart' => $sessArry]);
    }
}