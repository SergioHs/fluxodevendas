<?php

namespace App\Http\Controllers;

use App\Apartamento;
use App\Cliente;
use App\Empreendimento;
use App\Events\VendaCadastrada;
use App\TrilhaDeVendas;
use App\Venda;
use App\Vendedor;
use Illuminate\Http\Request;
use App\StatusVendasEnum;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with(['apartamento.empreendimento','vendedor', 'cliente', 'status'])->get();
        return view('vendas.index',['vendas' => $vendas]);
    }

    public function detail($id)
    {
        $venda = Venda::with(['apartamento.empreendimento','vendedor', 'cliente', 'status', 'trilhaDeVenda'])->findOrFail($id);
        return view('vendas.detail',['venda' => $venda]);
    }

    public function create(Request $r)
    {
        if ($r->query('apartamento')) {
            $apartamento = Apartamento::with('empreendimento')->findOrFail($r->query('apartamento'));
        }

        if ($r->query('cliente')) {
            $cliente = Cliente::findOrFail($r->query('cliente'));
        }

        $vendedores = Vendedor::get();
        $clientes = Cliente::get();
        $trilhas = TrilhaDeVendas::get();
        $empreendimentos = Empreendimento::get();

        return view('vendas.create', ['vendedores' => $vendedores, 'clientes' => $clientes, 'apartamento' => $apartamento, 'trilhas' => $trilhas, 'empreendimentos' => $empreendimentos, 'cliente' => isset($cliente) ? $cliente : null]);
    }

    public function store(Request $r)
    {
        $venda = new Venda();
        $venda->fill($r->all());
        $venda->statusvendas_id = StatusVendasEnum::RESERVADO;
        $venda->save();
        event(new VendaCadastrada($venda));

        $r->session()->flash('success', 'Venda iniciada com sucesso');
        return redirect()->action('VendaController@index');

    }

}