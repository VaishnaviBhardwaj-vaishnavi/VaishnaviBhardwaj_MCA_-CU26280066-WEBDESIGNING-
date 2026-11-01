<?php
require_once "../models/Product.php";

class ProductController {
    public function index() {
        $product = new Product();
        $products = $product->getProducts();

        require "../views/home.php";
    }
}
?>