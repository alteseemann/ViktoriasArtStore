<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function index(){//Отображает корзину на экране
        return view('cart');
    }

    public function add(Request $request){
        if (!$request->session()->exists('products')) {
            session(['products' => []]);
        }
        $id = $request->id;
        $request->session()->push('products', $id);
        $products                 = session('products');
        $data['cart_amount']      = count(array_unique($products));
        $data['amount']           = 1;
        return $this->sendResponse($data,'Товар добавлен в корзину');
    }

    public function remove(Request $request){
        $id = $request->id;
        $products = session('products');
        foreach ($products as $product){
            if ($product == $id){
                $index = array_search($id,$products);
                unset($products[$index]);
            }
        }
        $products = array_values($products);
        session(['products'=>$products]);
        $data['amount'] = 0;
        return $this->sendResponse($data,'Товар удален из корзины');
    }

    public function increase(Request $request){
        $id                       = $request->id;
        $request->session()->push('products', $id);
        $products                 = session('products');
        $data['amount']           = array_count_values($products)[$id];
        return $this->sendResponse($data,'Добавлена единица товара');
    }

    public function decrease(Request $request){
        $id             = $request->id;
        $products       = session('products');
        $index          = array_search($id,$products);//Индекс первого вхождения $id
        unset($products[$index]);//Удаление первого вхождения $id
        $products       = array_values($products);//Переиндексация массива (удаление значений null)
        $request->session()->forget('products');
        session(['products' => $products]);//Перезапись сессии
        $amount         = 0;
        foreach ($products as $product){
            if($product == $id){$amount++;}//Подсчет оставшихся
        }
        $data['amount'] = $amount;
        return $this->sendResponse($data,'');
    }

    public function getStatus(Request $request){
        $id = $request->id;
        if ($request->session()->exists('products') and in_array($id,session('products'))){
            $data['amount'] = array_count_values(session('products'))[$id];
        }else{
            $data['amount'] = 0;
        }
        return $this->sendResponse($data,'');
    }

    public function getProducts(Request $request){//возвращает продукты в корзине
        //Возвращает массив вида $products=[[$id,$amount,$image_path,$product_description,$price],[],...]
        if (!$request->session()->exists('products')) {
            session(['products' => []]);
            $data['products'] = [];
        }else{
            $session_products = $request->session()->get('products');//исходный массив корзины
            $ids              = $session_products;
            $ids              = array_unique($ids);//массив, содержащий id продуктов корзины в единственном экземпляре
            $products         = [];
            foreach ($ids as $id){
                $product = product::where('id',$id)->with(['images','type'])->first();
                $amount  = array_count_values($session_products)[$id];
                $path    = count($product->images)>0 ? "/storage/{$product->images[0]->path}" : "/storage/{$product->type->image}";
                $info    = $product->description;
                $price   = $product->price;
                array_push($products,[$id,$amount,$path,$info,$price]);
            }
            $data['products'] = $products;
        }
        return $this->sendResponse($data,'');
    }
}
