<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list() {
        return view('product.list');
    }

    public function details($slug) {

    }
}
