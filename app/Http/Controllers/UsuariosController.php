<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class UsuariosController extends Controller{

	/**
	*	Sprint: 	?.
	*	Spec-id: 	?-
	*
	* 	Obtiene todos los registros
	* de la entidad {@link Usuario}
	*
	* @return Illuminate\Http\JsonResponse
	* @author Paulo_Angeles.
	*/
	public function index(){
		$usuarios = Usuario::all();
		return response()->json($cliente,200);
	}

	/**
	*	Sprint: 	?.
	*	Spec-id: 	?-
	*
	* 	Obtiene el contenido del paginador
	* de la entidad {@link Usuario}
	*
	* @return Illuminate\Http\JsonResponse
	* @author Paulo_Angeles.
	*/
	public function parcial(int $pagina){
		Paginator::currentPageResolver(function() use ($pagina){
			return $pagina;
		});
		$paginadorUsuarios = Usuario::paginate(15);
		return response()->json($paginadorUsuarios,200);

	}

	/**
	*	Sprint: 	?.
	*	Spec-id: 	?-
	*
	* 	Obtiene obtiene los datos de
	* un {@link Usuario} determinado
	* por medio de su hashId.
	*
	* @return Illuminate\Http\JsonResponse
	* @author Paulo_Angeles.
	*/
	public function show(string $hashId){
		$usuario = Usuario::where('hashId', $hashId)->get();

		if(!$usuario){
			return response()->json([],404);
		}

		return response()->json($usuario,200);

	}

	/**
	*	Sprint: 	?.
	*	Spec-id: 	?-
	*
	* 	Elimina los datos de
	* un {@link Usuario} determinado
	* por medio de su hashId.
	*
	* @return Illuminate\Http\JsonResponse
	* @author Paulo_Angeles.
	*/
	public function destroy(string $hashId){
		
		$usuario = Usuario::where('hashId', $hashId)
		->get()
		->first();

		if(!$usuario){
			return response()->json([],404);
		}

		$usuario->delete();	
		
		return response()->json($usuario,200);

	}
}