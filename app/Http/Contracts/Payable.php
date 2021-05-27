<?php
namespace App\Http\Contracts;

interface Payable{
    public function pay(array $payment_data);
    public function confirmation();
    public function payment_success();
    public function payment_fail(array $errors);
}
