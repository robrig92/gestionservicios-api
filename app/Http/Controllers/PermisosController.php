<?php

namespace App\Http\Controllers;

use App\Permiso;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Recupera todos los recursos habilitados del almacenamiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permiso::enabled()->get();

		return response()->json($permisos, 200);
    }

    /**
     * Almacena un registro nuevo en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'descripcion' => 'string|required',
			'permiso' => 'string|required'
		]);

		// Obteniendo los parámetros requeridos.
		$args = $request->only([
			'descripcion',
			'permiso'
		]);

		// Completando los calculados.
		$args['enabled'] = true;

		// Intentamos persistir en almacenamiento.
		$permiso = Permiso::create($args);

		return response()->json($permiso, 201);
    }

    /**
     * Obtiene el recurso especificado.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $permiso = Permiso::find($id);

		// Registro no encontrado.
		if (!$permiso) {
			return response()->json(null, 404);
		}

		return response()->json($permiso, 200);
    }

    /**
     * Actualizamos el recurso especificado en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
			'enabled' => 'boolean|nullable',
			'descripcion' => 'string|required',
			'permiso' => 'string|required'
		]);

		// Tratamos de obtener el recurso.
		$permiso = Permiso::find($id);

		// Si no se encuentra el recurso.
		if (!$permiso) {
			return response()->json(null, 404);
		}

		// Actualizamos el objeto.
		$permiso->descripcion = $request->descripcion;
		$permiso->permiso = $request->permiso;
		(!isset($request->enabled)) ? : $permiso->enabled = $request->enabled;

		// Persistimos los cambios.
		$permiso->save();

		return response()->json($permiso, 200);
    }

    /**
     * Elimina un recurso del almacenamiento de manera lógica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscamos el registro.
        $permiso = Permiso::find($id);

		// Modificamos el objeto.
		$permiso->enabled = false;

		// Persistimos la información.
		$permiso->save();

		return response()->json($permiso, 200);
    }
}
