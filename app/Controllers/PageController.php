<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Image;


class PageController{

	public static function home(){

		$data["products"] = Product::with('images')->orderBy('updated_at','desc')->get()->toJson();

        view('home',$data);
    }

	public static function cart(){
		$data = [];
		view('cart',$data);
	}
	
	public static function add(){
		$data = [];
		view('add',$data);
	}

	public static function product(){	
		
		$product =  Product::where('id',$_GET['id'])->with("images")->first()->toJson();

		if($product == null) redirect('/'); 
		$data["product"] = $product;
	
		view('product',$data);
	}

	

	public static function edit(){	
		
		$product =  Product::where('id',$_GET['id'])->with("images")->first()->toJson();

		if($product == null) redirect('/'); 
		//dd($product);
		$data["product"] = $product;
	
		view('edit',$data);
	}

	public static function save(){

		$product = new Product;


		$product->name = $_POST["name"];
		$product->description = $_POST["description"];
		$product->quantity = $_POST["quantity"];
		$product->price = $_POST["price"];

		if($product->save()){	
			$imager = new \Imager($_FILES['files']);
			foreach($imager->save() as $uri){
				$image = new Image();
				$image->product_id = $product->id;
				$image->uri = $uri;
				$image->save();
			}	
			redirect("/add?type=success");
		}

	}

	public static function change(){

		$product = Product::where('id',$_POST["id"])->with("images")->first();

		$product->name = $_POST["name"];
		$product->description = $_POST["description"];
		$product->quantity = $_POST["quantity"];
		$product->price = $_POST["price"];

		if($product->save()){	
			/*$imager = new \Imager($_FILES['files']);
			foreach($imager->save() as $uri){
				$image = new Image();
				$image->product_id = $product->id;
				$image->uri = $uri;
				$image->save();
			}*/	
			redirect("/add?type=success");
		}

	}

	public static function delete(){
		$_POST = json_decode(file_get_contents("php://input"),true);

		$imager = new \Imager();

		$product = Product::where('id',$_POST["id"])->with("images")->first();
		
		foreach($product->images as $image){
			$imager->delete($image->uri);	
		} 		

		if($product->delete() == 1) return jsonrp("success","Deletado com sucesso!");

		return jsonrp("error","Ocorreu um erro inesperado ao deletar");
	}
}
