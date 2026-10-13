<?php

class OrderDetail
{
    private $id;
    private $order_id;
    private $product_id;
    private $quantity;
    private $price;

    public function __construct($id, $order_id, $product_id, $quantity, $price)
    {
        $this->id = $id;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getOrderId() {
        return $this->order_id;
    }

    public function getProductId() {
        return $this->product_id;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPrice() {
        return $this->price;
    }

    // Create Order Detail
    public function createOrderDetail($db)
    {
        $sql = "INSERT INTO order_details (order_id, product_id, quantity, price)
                VALUES ('$this->order_id', '$this->product_id', '$this->quantity', '$this->price')";

        $db->query($sql);
    }

    // Read Order Details
    public static function getOrderDetails($db)
    {
        $sql = "SELECT od.*, p.name as product_name FROM order_details od LEFT JOIN products p ON od.product_id = p.id";

        $result = $db->query($sql);

        return $result;
    }

    // Update Order Detail
    public function updateOrderDetail($db)
    {
        $sql = "UPDATE order_details
                SET quantity='$this->quantity',
                    price='$this->price'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete Order Detail
    public function deleteOrderDetail($db)
    {
        $sql = "DELETE FROM order_details WHERE id='$this->id'";

        $db->query($sql);
    }
}

?>