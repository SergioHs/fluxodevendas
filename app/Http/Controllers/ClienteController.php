<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 02/07/17
 * Time: 18:43
 */

namespace App\Http\Controllers;

use App\Cliente;
use App\Estado;
use Illuminate\Http\Request;


class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index',['clientes' => $clientes]);
    }

    public function create()
    {
        $estados = Estado::all();
        return view('clientes.create', ['estados' => $estados]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nome' => 'required|max:255'
        ]);

        $cliente = new Cliente();
        $cliente->fill($request->all());
        $cliente->save();
        redirect('/cliente');
    }


}