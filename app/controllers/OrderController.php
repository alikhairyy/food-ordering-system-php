<?php

require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../strategies/PaymentStrategy.php';
require_once __DIR__ . '/../strategies/CashPayment.php';
require_once __DIR__ . '/../strategies/CardPayment.php';
require_once __DIR__ . '/../strategies/WalletPayment.php';
require_once __DIR__ . '/../strategies/PaymentContext.php';

class OrderController
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "food_ordering_system");
    }

    // Show Orders
    public function index()
    {
        $orders = Order::getOrders($this->db);

        include __DIR__ . '/../views/orders/index.php';
    }

    // Create Order
    public function store()
    {
        $paymentMethod = $_POST['payment_method'];

        $payment = new PaymentContext();

        if ($paymentMethod == 'cash')
        {
            $payment->setPayment(new CashPayment());
        }
        elseif ($paymentMethod == 'card')
        {
            $payment->setPayment(new CardPayment());
        }
        else
        {
            $payment->setPayment(new WalletPayment());
        }

        $paymentResult = $payment->payNow($_POST['total_price']);

        $order = new Order(
            null,
            $_POST['user_id'],
            $_POST['total_price'],
            $_POST['status']
        );

        $order->createOrder($this->db);

        header("Location: index.php?action=orders");
        exit;
    }

    // Update Order
    public function update()
    {
        $order = new Order(
            $_POST['id'],
            $_POST['user_id'],
            $_POST['total_price'],
            $_POST['status']
        );

        $order->updateOrder($this->db);

        header("Location: index.php?action=orders");
        exit;
    }

    // Delete Order
    public function delete()
    {
        $order = new Order(
            $_GET['id'],
            0,
            0,
            ''
        );

        $order->deleteOrder($this->db);

        header("Location: index.php?action=orders");
        exit;
    }
}

?>