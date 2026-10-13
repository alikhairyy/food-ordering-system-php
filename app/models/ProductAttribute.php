<?php

require_once __DIR__.'/../config/database.php';

class ProductAttribute
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function readByProduct($productId)
    {
        $stmt = $this->conn->prepare(
            "SELECT a.attribute_name, pa.value
             FROM product_attributes pa
             JOIN attributes a
             ON pa.attribute_id = a.id
             WHERE pa.product_id = :pid"
        );

        $stmt->execute([':pid'=>$productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}