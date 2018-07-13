<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    /**
     * Obtiene todos los registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = Marca::all();

		return response()->json($marcas, 200);
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
			'marca' => 'required|string'
		]);

		// Obtenemos los argumentos del request.
		$args = $request->only([
			'enabled',
			'usuarioCreador',
			'marca'
		]);

		// Completando campos calculados.
		$args['createdAt'] = date('Y-m-d H:i:s');
		$args['updatedAt'] = null;

		// Persistimos en el almacenamiento.
		$marca = Marca::create($args);

		return response()->json($marca, 201);
    }

    /**
     * Obtiene un registro.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        // Verificamos que existe.
        $marca = Marca::find($id);

		if (!$marca) {
			return response()->json(null, 404);
		}

		return response()->json($marca, 200);
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
			'enabled' => 'required|boolean',
			'marca' => 'required|string'
		]);

		// Verificamos si existe el registro.
		$marca = Marca::find($id);

		// Modificamos el objeto con los argumentos.
		$marca->enabled = $request->enabled;
		$marca->updatedAt = $request->updatedAt;
		$marca->marca = $request->marca;

		// Completando campos calculados.
		$marca->updatedAt = date('Y-m-d H:i:s');

		// Persistimos los cambios en el almacenamiento.
		$marca->save();

		return response()->json($marca, 200);
    }

    /**
     * Elimina un registro del almacenamiento de manera lógica.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Verificamos que existe.
        $marca = Marca::find($id);

		if (!$marca) {
			return response()->json(null, 404);
		}

		// Borrado lógico.
		$marca->enabled = false;
		$marca->updatedAt = date('Y-m-d H:i:s');

		// Persistimos en el almacenamiento.
		$marca->save();

		return response()->json($marca, 200);
    }
}
