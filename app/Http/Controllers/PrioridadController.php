<?php

namespace App\Http\Controllers;

use App\Prioridad;
use Illuminate\Http\Request;

class PrioridadController extends Controller
{
    /**
     * Obtiene los registros activos del almacenamiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prioridades = Prioridad::enabled()->get();

		return response()->json($prioridades, 200);
    }

    /**
     * Persiste un nuevo registro en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'nombre' => 'required|string'
		]);

		// Obtenemos los argumentos requeridos.
		$args = $request->only('nombre');
		$args['enabled'] = (empty($request->enabled))
			? true
			: $request->enabled;

		// Obtenemos los campos calculados.
		$args['hashId'] = $this->createHashId();

		// Persistimos el registro.
		$prioridad = Prioridad::create($args);

		return response()->json($prioridad, 201);
    }

    /**
     * Obtiene el registro especificado.
     *
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function show(string $hashId)
    {
		// Buscamos el registro.
        $prioridad = Prioridad::withHashId($hashId)->first();

		if (!$prioridad) {
			return response()->json(null, 404);
		}

		return response()->json($prioridad, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $hashId)
    {
        $request->validate([
			'enabled' => 'required|boolean',
			'nombre' => 'required|string'
		]);

		// Buscamos el registro en el almacenamiento.
		$prioridad = Prioridad::withHashId($hashId)->first();

		if (!$prioridad) {
			return response()->json(null, 404);
		}

		// Modificamos el objeto.
		$prioridad->enabled = $request->enabled;
		$prioridad->nombre = $request->nombre;

		// Persistimos los cambios.
		$prioridad->save();

		return response()->json($prioridad, 200);
    }

    /**
     * Borrado lógico del registro.
     *
     * @param  string $hashId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $hashId)
    {
		// Buscamos el registro en el almacenamiento.
		$prioridad = Prioridad::withHashId($hashId)->first();

		if (!$prioridad) {
			return response()->json(null, 404);
		}

		// Modificamos el objeto.
		$prioridad->enabled = false;

		// Persistimos los cambios.
		$prioridad->save();

		return response()->json($prioridad, 200);
    }
}
