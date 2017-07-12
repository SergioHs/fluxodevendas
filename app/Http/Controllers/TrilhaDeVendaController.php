<?php

namespace App\Http\Controllers;
use App\Etapa;
use App\TrilhaDeVendas;
use Illuminate\Http\Request;

class TrilhaDeVendaController extends Controller
{
    public function index()
    {
        $trilhas = TrilhaDeVendas::all();
        return view('trilhasdevenda.index', ['trilhas' => $trilhas]);
    }

    public function create()
    {
        $etapas = Etapa::all();
        return view('trilhasdevenda.create', ['etapas' => $etapas]);
    }

    public function store()
    {

    }


}