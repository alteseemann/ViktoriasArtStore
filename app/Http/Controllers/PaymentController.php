<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Contracts\Payable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected Payable $payment_method;
    public function __construct(Payable $payment_method)
    {
        $this->payment_method = $payment_method;
    }

    public function index(Request $request){
        $data = $this->getOrderInfo($request);
        return view('order_blank')->with('data',$data);
    }

    public function getOrderInfo(Request $request){
        $shopping_cart   = $request->session()->get('products');
        $unify_products  = array_unique($request->session()->get('products'));
        $cart_price      = 0;
        $data['cart']    = [];
        foreach ($unify_products as $product_id){
            $product      = product::where('id',$product_id)->first();
            $price        = $product->price;
            $amount       = array_count_values($shopping_cart)[$product_id];
            $total_price  = $price*$amount;
            array_push($data['cart'],[$price,$amount,$total_price,$product->id,$product->title]);
            $cart_price += $total_price;
        }
        $data['cart_price'] = $cart_price;
        return $data;
    }

    public function pay(Request $request){

        $uri['previousUrl']      = route('welcome');
        $uri['nextUrl']          = route('welcome');
        $uri['paymentCancelUrl'] = route('welcome');
        $uri['paymentReturnUrl'] = route('welcome');

        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'user_surname' => 'required',
            'phone'=>'required|min:11|numeric',
            'email'=>'required|email',
            'address'=>'required',
            'index'=>'required|min:6|numeric',
        ]);
        $errors = $validator->errors()->all();
        if (count($errors)>0){
            return back()->with('errors',$errors);
        }

        $payment_data['user_name']       = $request->user_name;
        $payment_data['index']           = $request->index;
        $payment_data['user_surname']    = $request->user_surname;
        $payment_data['user_patronymic'] = $request->user_patronymic;
        $payment_data['email']           = $request->email;
        $payment_data['address']         = $request->address;
        $payment_data['phone']           = $request->phone;
        $payment_data['uri']             = $uri;
        $payment_data['description']     = 'Оплата корзины товаров';
        $payment_data['name']            = 'Покупка в магазине Artevik';
        $order_data                      = $this->getOrderInfo($request);
        $payment_data                    = array_merge($payment_data,$order_data);

        return $this->payment_method->pay($payment_data);
    }
}
