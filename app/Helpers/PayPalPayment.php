<?php
namespace App\Helpers;

use App\Http\Contracts\Payable;
use Exception;
use Illuminate\Support\Facades\Session;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Redirect;

class PayPalPayment implements Payable{

    public function pay(array $payment_data)
    {
        $payment_data['payment_method_id'] = 1;
        $api_parameters = [
            'cancelUrl'   => $payment_data['uri']['paymentCancelUrl'],
            'returnUrl'   => $payment_data['uri']['paymentReturnUrl'],
            'name'        => $payment_data['name'],
            'description' => $payment_data['description'],
            'amount'      => (float)($payment_data['cart_price']),
            'currency'    => 'RUB',
        ];

        //Создание платежного шлюза
        try {
            $gateway = Omnipay::create('PayPal_Express');
            $gateway->setUsername(config('payment.paypal.username'));
            $gateway->setPassword(config('payment.paypal.password'));
            $gateway->setSignature(config('payment.paypal.signature'));
            $gateway->setTestMode(config('payment.paypal.mode'));

            $response = $gateway->purchase($api_parameters)->send();
            $data = $response->getData();
            $payment_data = array_merge($payment_data,$data);
            session()->put('payment_data', $payment_data);
            //Обработка ответа от Paypal*************************************************
            //При вводе данных карты с пользовательской формы, все условия ниже обернуть в
            //еще одно главное условие - if ($response->isSuccessful){if{}elseif{}else{}}else{}
            if ($data['ACK'] == 'Success' && $response->isRedirect()) {
                //for express payments
                // Check if redirection to offsite payment gateway is needed
                return $response->redirect();
            } elseif ($response->isRedirect()) {
                //when the credit card data are provided from the form
                // Redirect to offsite payment gateway
                // Redirect to success URL to make the payment on the Paypal website
                return $response->redirect();
            } else {
                // Apply actions when Payment failed
                if (session()->exists('payment_data')) {
                    session()->forget('payment_data');
                }
                return back()->with('errors', ['При обработке платежа возникла ошибка!']);
            }
        }catch (Exception $e){
            if (session()->exists('payment_data')) {
                session()->forget('payment_data');
            }
            $exception = [
                'Exception type' => get_class($e),
                'Message'        => $e->getMessage(),
            ];
            return back()->with('exception',$exception);
        }
    }

    public function confirmation()
    {
        $payment_data = session()->get('payment_data');
        //Создание шлюза для проверки совершения платежа
        try{
            $gateway = Omnipay::create('PayPal_Express');
            $gateway->setUsername(config('payment.paypal.username'));
            $gateway->setPassword(config('payment.paypal.password'));
            $gateway->setSignature(config('payment.paypal.signature'));
            $gateway->setTestMode(config('payment.paypal.mode'));
            $response = $gateway->completePurchase($payment_data)->send();
            $data = $response->getData();
            //Обработка ответа от Paypal*************************************************
            //Check the Payment
            if (isset($data['PAYMENTINFO_0_ACK']) && $data['PAYMENTINFO_0_ACK'] === 'Success') {
                // Save the Transaction ID at the Provider (CORRELATIONID | PAYMENTINFO_0_TRANSACTIONID)
                if (isset($data['PAYMENTINFO_0_TRANSACTIONID'])) {
                    $payment_data['transaction_id'] = $data['PAYMENTINFO_0_TRANSACTIONID'];
                    session()->forget('payment_data');
                    session()->put('payment_data',$payment_data);
                }
                return $this->payment_success();
            }else{
                if (session()->exists('payment_data')) {
                    session()->forget('payment_data');
                }
                return $this->payment_fail(['Ошибка при обработке платежа']);
            }

        }catch (Exception $e){
            if (session()->exists('payment_data')) {
                session()->forget('payment_data');
            }
            $exception = [
                'Exception type' => get_class($e),
                'Message'        => $e->getMessage(),
            ];
            return $this->payment_fail($exception);
        }
    }

    public function payment_success(){
        return 'e';
    }
    public function payment_fail(array $errors){

    }
}
