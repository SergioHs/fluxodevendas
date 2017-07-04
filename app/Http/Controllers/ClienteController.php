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

    }

    public function create()
    {
        $estados = Estado::all();
        return view('clientes.create', ['estados' => $estados]);
    }

}