<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 03/07/17
 * Time: 20:04
 */
namespace App\Http\Controllers;
use App\Estado;

class CidadeController extends Controller
{
    public function getByEstado($estado_id)
    {
        $cidades = Estado::find($estado_id)->cidades->toArray();
        return response()->json($cidades);
    }
}