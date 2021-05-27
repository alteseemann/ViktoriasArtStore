<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\type;
use App\Models\genre;


class CatalogController extends Controller
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

    public function index(){
        $products = product::with(['images','type'])->get();
        $types    = type::where('is_active',1)->get();
        $genres   = genre::all();
        $artists  = '';
        $data = [
            'products'=>$products,
            'types'   => $types,
            'genres'  => $genres,
            'artists' => $artists,
        ];
        return view('welcome')->with($data);
    }

    public function catalog_item(Request $request){//просмотр элемента каталога
        $product = product::where('id',$request->id)->with(['images','type'])->first();
        $data = ['product'=>$product];
        return view('catalog.item')->with($data);
    }

    //Фильтры
    public function typeFilter(Request $request){
        $type_id  = $request->type;
        $genre_id = $request->isMethod('get') ? '' : $request->genre;
        if ($type_id == '' and $genre_id == ''){
            $products = product::with(['images','type'])->get();
        }elseif ($type_id != '' and $genre_id == ''){
            $products = product::where('type_id',$type_id)->with(['images','type'])->get();
        }elseif ($type_id == '' and $genre_id != ''){
            $products = product::where('genre_id',$genre_id)->with(['images','type'])->get();
        }elseif ($type_id != '' and $genre_id != ''){
            $products = product::where('type_id',$type_id)->where('genre_id',$genre_id)->with(['images','type'])->get();
        }
        $data = ['products'=>$products];
        if ($request->isMethod('get')){
            $types           = type::where('is_active',1)->get();
            $genres          = genre::all();
            $artists         = '';
            $data['types']   = $types;
            $data['genres']  = $genres;
            $data['artists'] = $artists;
            return view('welcome')->with($data);
        }
        return $this->sendResponse($data,'');
    }

}
