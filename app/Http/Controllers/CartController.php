<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function addToCart() {
        $cart = Cart::getInstance();
        $cartItem = $this->validate(request(), [
            'pid'   => 'required',
            'count' => 'required|integer|min:1',
        ]);

        if (!Product::find($cartItem['pid'])) {
            return new JsonResponse(['status' => 'error', 'message', 'Nincs ilyen termék']);
        }

        $cart->addToCart($cartItem['pid'], $cartItem['count']);
        $response = [
            'status' => 'success',
            'fn'     => "window.app.flashMessage('success', 'A termék hozzá lett adva a kosárhoz', 'Sikeres művelet!');$('#cartCounter').text('" . $cart->getCount() . "')",
        ];

        return new JsonResponse($response);
    }

    public function cart() {

    }
}
