<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show Products
    public function index()
    {
        require_once __DIR__ . '/../models/Menu.php';
        $products = Product::getProducts($this->db)->fetch_all(MYSQLI_ASSOC);
        $menus    = Menu::getMenus($this->db)->fetch_all(MYSQLI_ASSOC);

        include __DIR__ . '/../views/products/index.php';
    }

    // Create Product
    public function store()
    {
        $product = new Product(
            null,
            $_POST['name'],
            $_POST['price'],
            $_POST['menu_id']
        );

        $product->createProduct($this->db);

        header("Location: index.php?action=products");
    }

    // Update Product
    public function update()
    {
        $product = new Product(
            $_POST['id'],
            $_POST['name'],
            $_POST['price'],
            $_POST['menu_id']
        );

        $product->updateProduct($this->db);

        header("Location: index.php?action=products");
    }

    // Delete Product
    public function delete()
    {
        $product = new Product(
            $_GET['id'],
            '',
            0,
            0
        );

        $product->deleteProduct($this->db);

        header("Location: index.php?action=products");
    }
}

?>
