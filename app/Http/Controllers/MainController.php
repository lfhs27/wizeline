<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;

class MainController extends Controller
{
	protected $voca = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	
	public function index(){
		return view("index");
	}
	
	public function encode(Request $request){
		$link = Link::firstOrCreate(['url' => $request->url]);
		
		$id = $link->id;
		$hash = ""; 
		
		while($id > 0){
			$hash = $this->voca[$id%62].$hash;
			$id = intval($id/62);		
		}
		
		return redirect('/')->with('hash', $hash);
	}
	
	public function decode($hash){
		$id = 0;
		for($i = 0; $i < strlen($hash); $i++){
			$id += strpos($this->voca, $hash[$i])*pow(62, strlen($hash)-1-$i);
		}
		
		$link = Link::find($id);
		if($link){
			return redirect($link->url);
		}else{
			echo "No se encontró la liga";
		}
	}
}
