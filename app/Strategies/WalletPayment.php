<?php

require_once 'PaymentStrategy.php';

class WalletPayment implements PaymentStrategy
{
    public function pay($amount)
    {
        return "Paid $amount using Wallet";
    }
}

?>