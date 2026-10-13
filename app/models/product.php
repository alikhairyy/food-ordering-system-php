<?php

class Product
{
    private $id;
    private $name;
    private $price;
    private $menu_id;

    public function __construct($id, $name, $price, $menu_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->menu_id = $menu_id;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getMenuId() {
        return $this->menu_id;
    }

    // Create Product
    public function createProduct($db)
    {
        $sql = "INSERT INTO products (name, price, menu_id)
                VALUES ('$this->name', '$this->price', '$this->menu_id')";

        $db->query($sql);
    }

    // Read Products
    public static function getProducts($db)
    {
        $sql = "SELECT p.*, m.name as menu_name FROM products p LEFT JOIN menu m ON p.menu_id = m.id";

        $result = $db->query($sql);

        return $result;
    }

    // Update Product
    public function updateProduct($db)
    {
        $sql = "UPDATE products
                SET name='$this->name',
                    price='$this->price',
                    menu_id='$this->menu_id'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete Product
    public function deleteProduct($db)
    {
        $sql = "DELETE FROM products WHERE id='$this->id'";

        $db->query($sql);
    }
}

?>