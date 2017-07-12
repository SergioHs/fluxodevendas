<?php

namespace App\Http\Controllers;


class EtapaController extends Controller
{
    public function index()
    {
        return view('etapas.index');
    }

    public function create()
    {
        return view('etapas.create');
    }

    public function store()
    {

    }
}