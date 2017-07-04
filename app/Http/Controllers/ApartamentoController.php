<?php

namespace App\Http\Controllers;

use App\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    public function index()
    {
        return view('apartamento.index',['apartamento' => Apartamento::all()]);
    }
}
