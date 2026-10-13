<?php

class Order
{
    private $id;
    private $user_id;
    private $total_price;
    private $status;

    public function __construct($id, $user_id, $total_price, $status)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->total_price = $total_price;
        $this->status = $status;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getTotalPrice() {
        return $this->total_price;
    }

    public function getStatus() {
        return $this->status;
    }

    // Create Order
    public function createOrder($db)
    {
        $sql = "INSERT INTO orders (user_id, total_price, status)
                VALUES ('$this->user_id', '$this->total_price', '$this->status')";

        $db->query($sql);
    }

    // Read Orders
    public static function getOrders($db)
    {
        $sql = "SELECT * FROM orders";

        $result = $db->query($sql);

        return $result;
    }

    // Update Order
    public function updateOrder($db)
    {
        $sql = "UPDATE orders
                SET total_price='$this->total_price',
                    status='$this->status'
                WHERE id='$this->id'";

        $db->query($sql);
    }

    // Delete Order
    public function deleteOrder($db)
    {
        $sql = "DELETE FROM orders WHERE id='$this->id'";

        $db->query($sql);
    }
}

?>
