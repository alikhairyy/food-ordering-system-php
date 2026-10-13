<?php

require_once __DIR__ . '/../models/OrderDetail.php';

class OrderDetailController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show Order Details
    public function index()
    {
        $details = OrderDetail::getOrderDetails($this->db);

        include __DIR__ . '/../views/order_details/index.php';
    }

    // Create Order Detail
    public function store()
    {
        $detail = new OrderDetail(
            null,
            $_POST['order_id'],
            $_POST['product_id'],
            $_POST['quantity'],
            $_POST['price']
        );

        $detail->createOrderDetail($this->db);

        header("Location: index.php?action=order_details");
    }

    // Update Order Detail
    public function update()
    {
        $detail = new OrderDetail(
            $_POST['id'],
            $_POST['order_id'],
            $_POST['product_id'],
            $_POST['quantity'],
            $_POST['price']
        );

        $detail->updateOrderDetail($this->db);

        header("Location: index.php?action=order_details");
    }

    // Delete Order Detail
    public function delete()
    {
        $detail = new OrderDetail(
            $_GET['id'],
            0,
            0,
            0,
            0
        );

        $detail->deleteOrderDetail($this->db);

        header("Location: index.php?action=order_details");
    }
}

?>