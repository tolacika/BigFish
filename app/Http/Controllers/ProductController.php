<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function list() {
        $sort = \request('sort');
        if (empty($sort)) {
            $sort = 'nameAsc';
        }

        switch ($sort) {
            case "nameAsc":
            default:
                $products = Product::orderBy("title", "ASC")->get();
                break;
            case "nameDesc":
                $products = Product::orderBy("title", "DESC")->get();
                break;
            case "priceAsc":
                $products = Product::orderBy("price", "ASC")->get();
                break;
            case "priceDesc":
                $products = Product::orderBy("price", "DESC")->get();
                break;
        }
        return view('product.list')->with(['products' => $products, 'sort' => $sort]);
    }

    public function details($slug) {

    }
}
