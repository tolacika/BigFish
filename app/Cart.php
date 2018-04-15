<?php
/**
 * Created by PhpStorm.
 * User: Tolacika
 * Date: 2018. 04. 15.
 * Time: 14:09
 */

namespace App;


use App\Models\Discount;

class Cart {

    /** @var CartItem[] */
    private $items = [];

    /** @var Cart */
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

    public function getItems() {
        return $this->items;
    }

    public function getCount() {
        $count = 0;
        foreach ($this->items as $k => $item) {
            $count += $item->count;
        }

        return $count;
    }

    public function getFullPrice() {
        return $this->getPartPrice() - $this->get2plus1Discount();
    }

    public function getPartPrice() {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->product->getDiscountPrice() * $item->count;
        }

        return $price;
    }

    public function get2plus1Discount() {
        $disc = Discount::active()->where('discount_type', '2+1')->first();
        if ($disc->target_type == "single") {
            // Todo: Nincs benne a feladatban, de meg lehetne csinálni
            return 0;
        } elseif ($disc->target_type == "publisher") {
            $pub = $disc->target_reference;
            $prices = [];
            foreach ($this->items as $item) {
                if ($item->product->publisher == $pub) {
                    for ($i = 0; $i < $item->count; $i++) {
                        $prices[] = $item->product->getDiscountPrice();
                    }
                }
            }
            asort($prices);
            $prices = array_values($prices);
            $itemCount = count($prices);
            $needToFreeCount = intval(floor($itemCount / 3));
            $discount = 0;
            for ($i = 0; $i < $needToFreeCount && $i < $itemCount; $i++) {
                $discount += $prices[$i];
            }

            return $discount;
        }

        return 0;
    }

    public function hasValid2plus1Discount() {
        return $this->get2plus1Discount() > 0;
    }

    public function addToCart($pid, $count) {
        $found = null;
        foreach ($this->items as $k => $item) {
            if ($item->productId == $pid) {
                $found = $this->items[$k];
                $this->items[$k]->count += $count;
                break;
            }
        }
        if ($found === null) {
            $this->items[] = $found = new CartItem($pid, $count);
        }
        $this->save();

        return $found;
    }

    public function updateCartItem($pid, $count) {
        $found = null;
        foreach ($this->items as $k => $item) {
            if ($item->productId == $pid) {
                $found = $this->items[$k];
                $this->items[$k]->count = $count;
                break;
            }
        }
        if ($found === null) {
            $this->items[] = $found = new CartItem($pid, $count);
        }
        $this->save();

        return $found;
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