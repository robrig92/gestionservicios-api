<?php

namespace App\Http\Controllers;

use App\Notificacion;
use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Obtiene todos los registros del almacenamiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notificaciones = Notificacion::all();

		return response()->json($notificaciones, 200);
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
			'serverName' => 'string|required',
			'defaultEmail' => 'email|required',
			'smtpUser' => 'string|required',
			'smtpPort' => 'string|required',
			'smtpUsaSsl' => 'boolean|required',
			'smtpTextoHtml' => 'boolean|required',
			'defaultMessage' => 'string'
		]);

		// Obtenemos los argumentos requeridos para crear el registro.
		$args = $request->only([
			'serverName',
			'defaultEmail',
			'smtpUser',
			'smtpPass',
			'smtpPort',
			'smtpUsaSsl',
			'smtpTextoHtml',
			'defaultMessage'
		]);

		// Persistimos en el almacenamiento.
		$notificacion = Notificacion::create($args);

		return response()->json($notificacion, 201);
    }

    /**
     * Obtiene un registro.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        // Verificamos que existe el recurso.
        $notificacion = Notificacion::find($id);

		if (!$notificacion) {
			return response()->json(null, 404);
		}

		return response()->json($notificacion, 200);
    }

    /**
     * Actualiza un recurso en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
			'serverName' => 'string|required',
			'defaultEmail' => 'email|required',
			'smtpUser' => 'string|required',
			'smtpPort' => 'string|required',
			'smtpUsaSsl' => 'boolean|required',
			'smtpTextoHtml' => 'boolean|required',
			'defaultMessage' => 'string'
		]);

		// Verificamos que existe el registro.
		$notificacion = Notificacion::find($id);

		if (!$notificacion) {
			return response()->json(null, 404);
		}

		// Actualizamos los atributos del objeto.
		$notificacion->serverName = $request->serverName;
		$notificacion->defaultEmail = $request->defaultEmail;
		$notificacion->smtpUser = $request->smtpUser;
		$notificacion->smtpPass = $request->smtpPass;
		$notificacion->smtpPort = $request->smtpPort;
		$notificacion->smtpUsaSsl = $request->smtpUsaSsl;
		$notificacion->smtpTextoHtml = $request->smtpTextoHtml;
		$notificacion->defaultMessage = $request->defaultMessage;

		// Persistimos los cambios.
		$notificacion->save();

		return response()->json($notificacion, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        // Verificamos que existe el recurso.
        $notificacion = Notificacion::find($id);

		if (!$notificacion) {
			return response()->json(null, 404);
		}

		// Eliminamos el registro del almacenamiento.
		$notificacion->delete();

		return response()->json($notificacion, 200);
    }
}
