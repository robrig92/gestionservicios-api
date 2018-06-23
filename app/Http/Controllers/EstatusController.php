<?php

namespace App\Http\Controllers;

use App\Estatus;
use Illuminate\Http\Request;

class EstatusController extends Controller
{
    /**
     * Obtiene todos los registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estatus = Estatus::all();

		return response()->json($estatus, 200);
    }

    /**
     * Almacena un nuevo registro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'enabled' => 'boolean',
			'descripcion' => 'string|required',
			'nombre' => 'string|required'
		]);

		// Obtenemos los parámetros que requerimos.
		$args = $request->only(['enabled', 'descripcion', 'nombre']);

		// Persistimos el registro.
		$estatus = Estatus::create($args);

		return response()->json($estatus, 201);
    }

    /**
     * Obtiene un registro del almacenamiento.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        // Buscamos si existe el registro.
        $estatus = Estatus::find($id);

		if (!$estatus) {
			return response()->json(null, 404);
		}

		return response()->json($estatus, 200);
    }

    /**
     * Actualiza un registro en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
			'enabled' => 'boolean',
			'descripcion' => 'string|required',
			'nombre' => 'string|required'
		]);

		// Verificamos si existe el registro en el almacenamiento.
		$estatus = Estatus::find($id);

		if (!$estatus) {
			return response()->json(null, 404);
		}

		// Actualizamos los datos en el objeto.
		empty($request->enabled) ? : $estatus->enabled = $request->enabled;
		$estatus->descripcion = $request->descripcion;
		$estatus->nombre = $request->nombre;

		// Persistimos los cambios.
		$estatus->save();

		return response()->json($estatus, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Obtenemos el registro.
        $estatus = Estatus::find($id);

		if (!$estatus) {
			return response()->json(null, 404);
		}

		// Modificamos el objeto.
		$estatus->enabled = false;

		// Borrado lógico.
		$estatus->save();

		return response()->json($estatus, 200);
    }
}
