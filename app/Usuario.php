<?php
namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Usuario extends Model{
	/**
	*	Tipo de la conexión
	*
	* @var string
	*/
	protected $connection = 'mongodb';

	/**
	*	Nombre real dela colección
	*
	* @var string
	*/
	protected $collection = 'usuario';

	/**
	*	Llave primaria
	*
	* @var string
	*/
	protected $primaryKey = '_id';

	/**
	*	Deshabilita los timestamps por default de Eloquent
	*
	* @var boolean
	*/
	public $timestamps = false;

	/**
	*	Los atributos que pueden ser modificables
	*
	* @var array
	*/
	protected $fillable = [
		'enabled',
		'createdAt',
		'updateAt',
		'hashId',
		'nombre',
		'email',
		'telefono',
		'rol',
		'nickname',
		'password'
		];

	/**
	 * Attributos invisibles para la serialización.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password'
	];
}

?>