<?php

namespace App\Http\Controllers;

use App\Servicio;
use Illuminate\Http\Request;

class ServiciosController extends Controller
{
	/**
     * Obtiene todos los registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::all();

		return response()->json($servicios, 200);
    }

    /**
     * Persiste un registro en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'enabled' => 'required|boolean',
			'usuarioCreador' => 'required|string',
			'descripcion' => 'required|string',
			'precio' => 'required|numeric',
			'observaciones' => 'nullable|string',
			'tiempoPromedio' => 'required|string'
		]);

		// Obtenemos los argumentos del request.
		$args = $request->only([
			'enabled',
			'usuarioCreador',
			'descripcion',
			'precio',
			'tiempoPromedio'
		]);

		// Obtenemos argumentos no requeridos del request.
		$args['observaciones'] = isset($request->obervaciones)
			? $request->observaciones
			: '';

		// Completando campos calculados.
		$args['hashId'] = $this->createHashId();
		$args['createdAt'] = date('Y-m-d H:i:s');
		$args['updatedAt'] = null;

		// Persistimos en el almacenamiento.
		$servicio = Servicio::create($args);

		return response()->json($servicio, 201);
    }

    /**
     * Obtiene un registro.
     *
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function show(string $hashId)
    {
        // Verificamos que existe.
        $servicio = Servicio::withHashId($hashId)->first();

		if (!$servicio) {
			return response()->json(null, 404);
		}

		return response()->json($servicio, 200);
    }

    /**
     * Actualiza un registro en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $hashId)
    {
		$request->validate([
			'enabled' => 'required|boolean',
			'descripcion' => 'required|string',
			'precio' => 'required|numeric',
			'observaciones' => 'nullable|string',
			'tiempoPromedio' => 'required|string'
		]);

		// Verificamos si existe el registro.
		$servicio = Servicio::withHashId($hashId)->first();

		// Modificamos el objeto con los argumentos.
		$servicio->precio = $request->precio;
		$servicio->enabled = $request->enabled;
		$servicio->updatedAt = $request->updatedAt;
		$servicio->descripcion = $request->descripcion;
		$servicio->tiempoPromedio = $request->tiempoPromedio;
		!isset($request->observaciones) ? : $servicio->observaciones = $request->observaciones;

		// Completando campos calculados.
		$servicio->updatedAt = date('Y-m-d H:i:s');

		// Persistimos los cambios en el almacenamiento.
		$servicio->save();

		return response()->json($servicio, 200);
    }

    /**
     * Elimina un registro del almacenamiento de manera lógica.
     *
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $hashId)
    {
        // Verificamos que existe.
        $servicio = Servicio::withHashId($hashId)->first();

		if (!$servicio) {
			return response()->json(null, 404);
		}

		// Borrado lógico.
		$servicio->enabled = false;
		$servicio->updatedAt = date('Y-m-d H:i:s');

		// Persistimos en el almacenamiento.
		$servicio->save();

		return response()->json($servicio, 200);
    }
}
