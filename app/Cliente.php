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

}

?>
