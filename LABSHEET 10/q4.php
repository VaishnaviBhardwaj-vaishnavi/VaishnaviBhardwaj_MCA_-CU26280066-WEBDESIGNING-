<?php
require_once "../controllers/ProductController.php";

$url = $_GET['url'] ?? 'home';

switch ($url) {

    case 'home':
        echo "Welcome to Home Page";
        break;

    case 'products':
        $controller = new ProductController();
        $controller->index();
        break;

    default:
        http_response_code(404);
        echo "404 Page Not Found";
}
?>