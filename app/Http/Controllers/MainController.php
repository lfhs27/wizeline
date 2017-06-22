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
}
