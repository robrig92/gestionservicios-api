<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Estatus extends Model
{
	/**
	 * Tipo de la conexión.
	 *
	 * @var string
	 */
    protected $connection = 'mongodb';

	/**
	 * Nombre real de la colección.
	 *
	 * @var string
	 */
	protected $collection = 'estatus';

	/**
	 * Llave primaria.
	 *
	 * @var string
	 */
	protected $primaryKey = '_id';

	/**
	 * Deshabilita los timestamps por default de Eloquent.
	 *
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Los atributos que pueden ser modificados.
	 * @var [type]
	 */
	protected $fillable = [
		'enabled', 'descripcion', 'nombre'
	];
}
