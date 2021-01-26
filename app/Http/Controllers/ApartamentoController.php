<?php

namespace App\Http\Controllers;

use App\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('apartamento.index',['apartamento' => Apartamento::all()]);
    }
}
