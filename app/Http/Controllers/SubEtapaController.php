<?php

namespace App\Http\Controllers;


class SubEtapaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

}