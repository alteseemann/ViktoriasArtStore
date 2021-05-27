<?php

namespace App\Http\Controllers\Admin;

use App\Models\image;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostAdminController extends Controller
{
    public function index()
    {
        $types = type::all();
        $data = [
            'types'=>$types,
        ];
        return view('Admin.Posts.Add')->with($data);
    }

    public function add(Request $request){
        //Валидация формы
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'type_select' => 'required',
            'product_price'=>'required',
        ]);
        //проверка расширений файлов
        $files = [];
        $validate = false;
        for ($i=1;$i<=3;$i++){
            if (!is_null($request->file("img$i"))){
                $files[$i] = $request->file("img$i");
            }
        }
        if (count($files)>0){
            foreach ($files as $file){
                $ext      = $file->getMimeType();
                $required = ['image/jpeg','image/gif','image/png'];
                $validate = in_array($ext,$required);
            }
        }
        //Обработка ошибок формы
        $errors = [];
        if ($validate == false){
            array_push($errors,'Изображения должны быть в формате JPG или PNG');
        }
        if ($validator->fails()){
            array_push($errors,'Заполните все поля формы');
        }
        if (count($files) == 0){
            array_push($errors,'Добавьте хотя бы одно изображение');
        }
        if (count($errors)>0) {
            return redirect(route('post_add'))->with(['errors'=>$errors]);
        }
        //Добавление товара в базу
        $rus_title = $request->product_name;
        $title     = $request->product_title;
        $user_id   = auth()->user()->id;
        $price     = $request->product_price;
        $type_id   = $request->type_select;
        $data      = [
            'title'    =>$title,
            'rus_title'=>$rus_title,
            'user_id'  =>$user_id,
            'price'    =>$price,
            'type_id'  =>$type_id,
        ];
        $product   = product::create($data);
        $product_id=$product->id;
        //Сохранение изображений
        foreach ($files as $file){
            $filename = "{$product_id}_{$file->getClientOriginalName()}";
            $path = Storage::disk('public')->putFileAs('product_images',$file,$filename);//сохранить в хранилище
            $image = image::create([
                'product_id'=>$product_id,
                'path'      =>$path,
            ]);//сохранить в БД
        }
        //Storage::exists($path)
        return view('Admin.home')->with($data);
    }
}
