<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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
	 * Obtiene contenido del paginador de registros.
	 *
	 * @return Illuminate\Http\JsonResponse
	 */
    public function parcial(int $pagina)
    {
    	Paginator::currentPageResolver(function() use ($pagina) {
		    return $pagina;
		});
    	$paginadorClientes = Cliente::paginate(15);
		return response()->json($paginadorClientes, 200);
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
			'usuarioCreador' => 'required|string',
			'nombreContacto' => 'required|string',
			'razonSocial' => 'string|nullable',
			'nombreComercial' => 'string|nullable',
			'calle' => 'required|string',
			'numInterior' => 'string|nullable',
			'numExterior' => 'string|nullable',
			'colonia' => 'string|nullable',
			'codigoPostal' => 'string|max:5|nullable',
			'municipio' => 'required|string',
			'estado' => 'required|string',
			'telefono' => 'string|max:10|nullable',
			'email' => 'email|required',
			'password' => 'string|required'
		]);

		// Obtenemos los argumentos a persistir.
		$args = $request->only([
			'enabled',
			'usuarioCreador',
			'nombreContacto',
			'razonSocial',
			'nombreComercial',
			'calle',
			'numInterior',
			'numExterior',
			'colonia',
			'codigoPostal',
			'municipio',
			'estado',
			'telefono',
			'email',
			'password'
		]);

		// Encriptando el password.
		$args['password'] = bcrypt($args['password']);

		// Completando los calculados.
		$args['hashId'] = md5(now());

		$args['createdAt'] = date('Y-d-m H:i:s');
		$args['updatedAt'] = null;

		// Persistiendo el registro.
		$cliente = Cliente::create($args);

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
			'nombreContacto' => 'required|string',
			'razonSocial' => 'string|nullable',
			'nombreComercial' => 'string|nullable',
			'calle' => 'string',
			'numInterior' => 'string|nullable',
			'numExterior' => 'string|nullable',
			'colonia' => 'string|nullable',
			'codigoPostal' => 'string|max:5|nullable',
			'municipio' => 'required|string',
			'estado' => 'required|string',
			'telefono' => 'string|max:10|nullable',
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
		$cliente->calle = $request->calle;
		empty($request->numInterior) ?
			: $cliente->numInterior = $request->numInterior;
		empty($request->numExterior) ?
			: $cliente->numExterior = $request->numExterior;
		empty($request->colonia) ?
			: $cliente->colonia = $request->colonia;
		empty($request->codigoPostal) ?
			: $cliente->codigoPostal = $request->codigoPostal;
		$cliente->municipio = $request->municipio;
		$cliente->estado = $request->estado;
		$cliente->telefono = $request->telefono;
		empty($cliente->email) ? : $cliente->email = $request->email;
		empty($request->password) ? : $cliente->password = $request->password;

		// Campos calculados.
		$cliente->updatedAt = date('Y-m-d H:i:s');

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
		// Comprobamos que existe.
		$cliente = Cliente::where($hashId)
			->get()
			->first();

		if (!$cliente) {
			return response()->json(null, 404);
		}

		// Eliminamos físicamente el registro.
		$cliente->delete();

		return response()->json($cliente, 200);
	}
}
