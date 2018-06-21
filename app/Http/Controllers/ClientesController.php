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
		$cliente = Cliente::where('hashId', $hashId)
			->get()
			->first();

		if (!$cliente) {
			return response()->json([], 404);
		}

		// Actualizamos los datos del objeto.
		empty($request->enabled) ? : $cliente->enabled = $request->enabled;
		$cliente->updatedAt = $request->updatedAt;
		empty($cliente->nombreContacto) ?
			: $cliente->nombreContacto = $request->nombreContacto;
		$cliente->razonSocial = $request->razonSocial;
		$cliente->nombreComercial = $request->nombreComercial;
		$cliente->direccion = $request->direccion;
		$cliente->telefono = $request->telefono;
		empty($cliente->email) ? : $cliente->email = $request->email;
		empty($request->password) ? : $cliente->password = $request->password;

		// Actualizamos el registro.
		$cliente->save();

		return response()->json($cliente, 200);
	}

	/**
	 * Elimina un registro.
	 *
	 * @param  string $hashId
	 * @return Illuminate/Http/JsonResponse
	 */
	public function destroy(string $hashId)
	{
		$cliente = Cliente::where($hashId)
			->get()
			->first();

		if (!$cliente) {
			return response()->json(null, 404);
		}

		$cliente->delete();

		return response()->json($cliente, 200);
	}
}
