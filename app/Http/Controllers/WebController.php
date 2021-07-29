<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller ;
use App\Models\History;

class WebController extends Controller
{
    public function home(){ 
        return view('home');
    } 

    public function history(){
        $history = History::OrderBy('id', 'DESC')->paginate(200); 
        return view('history', compact('history'));
    }

}
