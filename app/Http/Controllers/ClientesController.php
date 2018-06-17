<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {
    	$clientes = Cliente::all();
		return $clientes;
    }
}
