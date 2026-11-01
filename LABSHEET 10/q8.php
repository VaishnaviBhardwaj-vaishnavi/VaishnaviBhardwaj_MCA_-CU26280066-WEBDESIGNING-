<?php

$conn = new PDO(
    "mysql:host=localhost;dbname=myproject_db;charset=utf8mb4",
    "myproject_user",
    "CHANGE_THIS_PASSWORD"
);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {

    case 'GET':

        $stmt = $conn->query("SELECT * FROM products");

        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

        break;

    case 'POST':

        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "INSERT INTO products(name, price) VALUES(?, ?)"
        );

        $stmt->execute([
            $data['name'],
            $data['price']
        ]);

        echo json_encode(["message"=>"Product added"]);

        break;

    case 'PUT':

        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "UPDATE products SET name=?, price=? WHERE id=?"
        );

        $stmt->execute([
            $data['name'],
            $data['price'],
            $data['id']
        ]);

        echo json_encode(["message"=>"Product updated"]);

        break;

    case 'DELETE':

        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "DELETE FROM products WHERE id=?"
        );

        $stmt->execute([$data['id']]);

        echo json_encode(["message"=>"Product deleted"]);

        break;

    default:
        http_response_code(405);
        echo json_encode(["error"=>"Invalid method"]);
}
?>