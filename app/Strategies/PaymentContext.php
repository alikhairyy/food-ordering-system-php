<?php

class PaymentContext
{
    private $strategy;

    public function setPayment(PaymentStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function payNow($amount)
    {
        return $this->strategy->pay($amount);
    }
}

?>