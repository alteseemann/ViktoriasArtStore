<?php
namespace App\Helpers;

use App\Http\Contracts\Payable;
class SberPayment implements Payable{
    public function pay()
    {
        // TODO: Implement pay() method.
        echo 'ok';
    }
    public function payment_success(){

    }
    public function payment_fail(){

    }
}
