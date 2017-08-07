<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

class Sales
{
    public function testPayment(array $data, $amount)
    {
        $payment = new PaypalPayment;
        try {
            $payment->validate($data, function ($testAmount) use ($amount) {
                return $this->test($amount, $testAmount);
            });
        } catch (\PaypalException $e) {
            new \RuntimeException('something weird', 23, $e);
        }

        return $payment;
    }

    public function test($amount, $testAmount)
    {
        return $amount === $testAmount;
    }
}

class PaypalPayment
{
    private $testAmount = 200;

    public function validate(array $data, closure $comparator)
    {
        if (!$comparator($this->testAmount)) {
            throw new \PaypalException("Incorrect amount");
        }
    }

}


class PaypalException extends Exception {

}

(new Sales)->testPayment([], 200);