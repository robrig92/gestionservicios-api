<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
	/**
	 * Obtiene todos los registros.
	 *
	 * @return Illuminate\Http\JsonResponse
	 */
    public function index()
    {
    	$clientes = Cliente::all();
		return response()->json($clientes, 200);
    }

	/**
	 * Muestra un registro con el ID obtenido.
	 *
	 * @param  string $hashId
	 * @return Illuminate\Http\JsonResponse
	 */
	public function show(string $hashId)
	{
		$cliente = Cliente::where('hashId', $hashId)->get();

		if (!$cliente) {
			return response()->json([], 404);
		}

		return response()->json($cliente, 200);
	}

	/**
	 * Crea un registro nuevo.
	 *
	 * @param  Request $request
	 * @return Illuminate\Http\JsonResponse
	 */
	public function store(Request $request)
	{
		$request->validate([
			'enabled' => 'boolean',
			'createdAt' => 'required|date',
			'updatedAt' => 'date',
			'usuarioCreador' => 'required|string',
			'nombreContacto' => 'required|string',
			'razonSocial' => 'string',
			'nombreComercial' => 'string',
			'direccion' => 'string',
			'telefono' => 'string|max:10',
			'email' => 'email|required',
			'password' => 'string|required'
		]);

		// Encriptando el password.
		$request->password = bcrypt($request->password);
		$fields = $request->all();
		$fields['hashId'] = md5(now());

		// Insertando el registro.
		$cliente = Cliente::create($request->all());

		return response()->json($cliente, 201);
	}

	/**
	 * Actualizamos un registro por su hashId.
	 * @param  Request $request
	 * @param  string  $hashId
	 * @return Illuminate\Http\JsonResponse
	 */
	public function update(Request $request, string $hashId)
	{
		$request->validate([
			'enabled' => 'boolean',
			'updatedAt' => 'required|date',
			'nombreContacto' => 'required|string',
			'razonSocial' => 'string',
			'nombreComercial' => 'string',
			'direccion' => 'string',
			'telefono' => 'string|max:10',
			'email' => 'email|required',
			'password' => 'string'
		]);

		// Buscamos si existe el cliente.
		$cliente = Cliente::where('hashIsh', $hashId)->get();

		if (!$cliente) {
			return response()->json([], 404);
		}

		// Actualizamos los datos del objeto.
		empty($request->password) ? : $cliente->password = $request->password;

		// Actualizamos el registro.
		Cliente::where('hashId', $hashId)
			->update($request->all());

		$cliente = Cliente::find('hashId', $hashId)->get();

		return response()->json($cliente[0], 200);
	}
}
