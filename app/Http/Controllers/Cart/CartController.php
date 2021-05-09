<?php

namespace App\Http\Controllers\Cart;
use App\Http\Controllers\Controller;


class CartController  extends Controller {

	
    public function index() {
		$page_title = "Your Cart  ";
		return view('fashion.carts.index',compact('page_title'));
	}
	

}