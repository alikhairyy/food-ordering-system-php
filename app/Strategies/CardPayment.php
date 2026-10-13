<?php

require_once 'PaymentStrategy.php';

class CardPayment implements PaymentStrategy
{
    public function pay($amount)
    {
        return "Paid $amount using Card";
    }
}

?>