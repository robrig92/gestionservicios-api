<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;

class RolesController extends Controller
{
	/**
     * Recupera todos los recursos habilitados del almacenamiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Rol::enabled()->get();

		return response()->json($roles, 200);
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
			'nombre' => 'string|required',
			'usuarioCreador' => 'string|required'
		]);

		// Obteniendo los parámetros requeridos.
		$args = $request->only([
			'nombre',
			'usuarioCreador'
		]);

		// Completando los calculados.
		$args['enabled'] = true;
		$args['createdAt'] = date('Y-m-d H:i:s');
		$args['updatedAt'] = null;
		$args['hashId'] = $this->createHashId();

		// Intentamos persistir en almacenamiento.
		$rol = Rol::create($args);

		return response()->json($rol, 201);
    }

    /**
     * Obtiene el recurso especificado.
     *
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function show(string $hashId)
    {
        $rol = Rol::withHashId($hashId)->first();

		// Registro no encontrado.
		if (!$rol) {
			return response()->json(null, 404);
		}

		return response()->json($rol, 200);
    }

    /**
     * Actualizamos el recurso especificado en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hashId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $hashId)
    {
        $request->validate([
			'enabled' => 'boolean|nullable',
			'nombre' => 'string|required'
		]);

		// Tratamos de obtener el recurso.
		$rol = Rol::withHashId($hashId)->first();

		// Si no se encuentra el recurso.
		if (!$rol) {
			return response()->json(null, 404);
		}

		// Actualizamos el objeto.
		$rol->nombre = $request->nombre;
		(!isset($request->enabled)) ? : $rol->enabled = $request->enabled;

		// Seteando argumenos calculados.
		$rol->updated = date('Y-m-d H:i:s');

		// Persistimos los cambios.
		$rol->save();

		return response()->json($rol, 200);
    }

    /**
     * Elimina un recurso del almacenamiento de manera lógica.
     *
     * @param  string $hashId
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $hashId)
    {
        // Buscamos el registro.
        $rol = Rol::withHashId($hashId)->first();

		// Modificamos el objeto.
		$rol->enabled = false;

		// Persistimos la información.
		$rol->save();

		return response()->json($rol, 200);
    }
}
