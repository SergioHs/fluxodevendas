<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controllers;
use Illuminate\Http\Request;

class TestController extends Controller {


    public function show()
    {
        return view('test.show', ['nome' => 'TEYTEY']);
    }

    public function insert(Request $req)
    {

    }
}