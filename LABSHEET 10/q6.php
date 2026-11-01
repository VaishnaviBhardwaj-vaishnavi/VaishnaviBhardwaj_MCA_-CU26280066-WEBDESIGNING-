<?php
require_once "../config/Database.php";

class Product {

    private $conn;

    public function __construct() {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    // CREATE
    public function create($name, $price) {

        $sql = "INSERT INTO products(name, price)
                VALUES(:name, :price)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':price' => $price
        ]);
    }

    // READ
    public function read() {

        $stmt = $this->conn->query("SELECT * FROM products");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $name, $price) {

        $sql = "UPDATE products
                SET name=?, price=?
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([$name, $price, $id]);
    }

    // DELETE
    public function delete($id) {

        $stmt = $this->conn->prepare(
            "DELETE FROM products WHERE id=?"
        );

        return $stmt->execute([$id]);
    }
}
?>