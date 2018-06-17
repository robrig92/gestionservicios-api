<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
	/**
	 * Obtiene todos los registros.
	 *
	 * @return JsonResponse
	 */
    public function index()
    {
    	$clientes = Cliente::all();
		return response()->json($clientes, 200);
    }
}
