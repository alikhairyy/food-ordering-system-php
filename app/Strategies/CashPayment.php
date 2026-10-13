<?php

require_once 'PaymentStrategy.php';

class CashPayment implements PaymentStrategy
{
    public function pay($amount)
    {
        return "Paid $amount using Cash";
    }
}

?>