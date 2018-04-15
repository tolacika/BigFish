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
            'count' => 'required|numeric|min:1',
        ]);

        if (!Product::find($cartItem['pid'])) {
            return new JsonResponse(['status' => 'error', 'message', 'Nincs ilyen termék']);
        }

        $cart->addToCart($cartItem['pid'], $cartItem['count']);

        $fn = "window.app.flashMessage('success', 'A termék hozzá lett adva a kosárhoz', 'Sikeres művelet!');";
        $fn .= "$('#cartCounter').text('" . $cart->getCount() . " termék - " . number_format($cart->getFullPrice(), 0, '', ' ') . " Ft');";

        $response = [
            'status' => 'success',
            'fn'     => $fn,
        ];

        return new JsonResponse($response);
    }

    public function updateCart() {
        $cart = Cart::getInstance();
        $cartItem = $this->validate(request(), [
            'pid'   => 'required',
            'count' => 'required|numeric|min:1',
            'rowId' => 'required|integer',
        ]);

        if (!Product::find($cartItem['pid'])) {
            return new JsonResponse(['status' => 'error', 'message', 'Nincs ilyen termék']);
        }

        $item = $cart->updateCartItem($cartItem['pid'], $cartItem['count']);

        $fn = "window.app.flashMessage('success', 'A termék mennyisége frissítve lett', 'Sikeres művelet!');";
        $fn .= "$('#cartCounter').text('" . $cart->getCount() . " termék - " . number_format($cart->getFullPrice(), 0, '', ' ') . " Ft');";

        $fn .= "$('.cartTable tr[data-row-id=\"" . $cartItem['rowId'] . "\"] .finalPrice strong').text('"
               . $item->product->formatPrice($item->product->getDiscountPrice() * $item->count, true) . "');";

        $fn .= "$('.cartTable strong.partPrice').text('" . number_format($cart->getPartPrice(), 0, '', ' ') . "');";
        $fn .= "$('.cartTable strong.discount2plus1').text('" . number_format(-1 * $cart->get2plus1Discount(), 0, '', ' ') . "');";
        $fn .= "$('.cartTable strong.finalPrice').text('" . number_format($cart->getFullPrice(), 0, '', ' ') . "');";

        $response = [
            'status' => 'success',
            'fn'     => $fn,
        ];

        return new JsonResponse($response);
    }

    public function deleteCart() {
        $cart = Cart::getInstance();
        $cartItem = $this->validate(request(), [
            'pid'   => 'required',
            'rowId' => 'required|numeric',
        ]);

        if (!Product::find($cartItem['pid'])) {
            return new JsonResponse(['status' => 'error', 'message', 'Nincs ilyen termék']);
        }

        $cart->removeFromCart($cartItem['pid']);
        $fn = "window.app.flashMessage('success', 'A termék törölve lett', 'Sikeres művelet!');"
              . "$('.cartTable tr[data-row-id=\"" . $cartItem['rowId'] . "\"]').remove();";

        $fn .= "$('#cartCounter').text('" . $cart->getCount() . " termék - " . number_format($cart->getFullPrice(), 0, '', ' ') . " Ft');";

        $fn .= "$('.cartTable strong.partPrice').text('" . number_format($cart->getPartPrice(), 0, '', ' ') . "');";
        $fn .= "$('.cartTable strong.discount2plus1').text('" . number_format(-1 * $cart->get2plus1Discount(), 0, '', ' ') . "');";
        $fn .= "$('.cartTable strong.finalPrice').text('" . number_format($cart->getFullPrice(), 0, '', ' ') . "');";

        $response = [
            'status' => 'success',
            'fn'     => $fn,
        ];

        return new JsonResponse($response);
    }

    public function cart() {
        return view('cart')->with(['cart' => Cart::getInstance()]);
    }
}
