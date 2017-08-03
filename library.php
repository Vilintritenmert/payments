<?php

class Sales
{
    public function testPayment(array $data, $amount)
    {
        $payment = new PaypalPayment;
        try {
            $payment->validate($data, function ($testAmount) {
                return $this->test($amount, $testAmount);
            });
        } catch (\PaypalException $e) {
            new \RuntimeException('something weird', 23, $e);
        }
        return $payment;
    }
}

class PaypalPayment
{
    private $testAmount = 200;

    public function validate(array $data, callable $comparator)
    {
        if (!$comparator($this->testAmount)) {
            throw new \PaypalException("Incorrect amount");
        }
    }

    private function test($amount, $testAmount)
    {
        return $amount == $testAmount;
    }
}

(new Sales)->testPayment([], 200);