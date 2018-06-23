<?php
namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Cliente extends Model {
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
	protected $collection = 'cliente';

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
	 * Los attributos que pueden ser modificables.
	 *
	 * @var array
	 */
	protected $fillable = [
		'enabled',
		'createdAt',
		'updatedAt',
		'hashId',
		'usuarioCreador',
		'nombreContacto',
		'razonSocial',
		'nombreComercial',
		'direccion',
		'telefono',
		'email',
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
