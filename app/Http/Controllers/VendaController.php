<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Cliente;
use App\Empreendimento;
use App\Estado;
use App\TrilhaDeVendas;
use App\Vendedor;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {

    }

    public function create(Request $r)
    {
        if($r->query('apartamento')){
            $apartamento = Apartamento::with('empreendimento')->findOrFail($r->query('apartamento'));
        }

        if($r->query('cliente')){
            $cliente = Cliente::findOrFail($r->query('cliente'));
        }

        $vendedores = Vendedor::get();
        $clientes = Cliente::get();
        $trilhas = TrilhaDeVendas::get();
        $empreendimentos = Empreendimento::get();

        return view('vendas.create',['vendedores' => $vendedores, 'clientes' => $clientes, 'apartamento' => $apartamento, 'trilhas' => $trilhas, 'empreendimentos' => $empreendimentos, 'cliente' => isset($cliente) ? $cliente : null]);
    }
}