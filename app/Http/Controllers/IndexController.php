<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JavaScript;

class IndexController extends Controller
{
    public function index() {

        if (auth()->check()) {
            JavaScript::put([
                'isAuth' => true,
                'user' => auth()->user(),
            ]);
        } else {
            JavaScript::put( ['isAuth' => false] );
        }
    
        return view('welcome');
    }
}
