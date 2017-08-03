<?php

class Sales
{
    public function testPayment(array $data, $amount)
    {
        $payment = new PaypalPayment;
        try {
            $payment->validate($data, function ($testAmount) use ($amount, $payment) {
                return $payment->test($amount, $testAmount);
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

    public function test($amount, $testAmount)
    {
        return $amount === $testAmount;
    }
}


class PaypalException extends Exception {

}

(new Sales)->testPayment([], 200);