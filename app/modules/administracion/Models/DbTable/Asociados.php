<?php 
/**
* clase que genera la insercion y edicion  de Asociados en la base de datos
*/
class Administracion_Model_DbTable_Asociados extends Db_Table
{
	/**
	 * [ nombre de la tabla actual]
	 * @var string
	 */
	protected $_name = 'asociados';

	/**
	 * [ identificador de la tabla actual en la base de datos]
	 * @var string
	 */
	protected $_id = 'asociado_id';

	/**
	 * insert recibe la informacion de un Asociados y la inserta en la base de datos
	 * @param  array Array array con la informacion con la cual se va a realizar la insercion en la base de datos
	 * @return integer      identificador del  registro que se inserto
	 */
	public function insert($data){
		$asociado_nit = $data['asociado_nit'];
		$asociado_nombre = $data['asociado_nombre'];
		$asociado_clave = $data['asociado_clave'];
    $asociado_clave = password_hash($asociado_clave, PASSWORD_DEFAULT);
		$query = "INSERT INTO asociados( asociado_nit, asociado_nombre, asociado_clave) VALUES ( '$asociado_nit', '$asociado_nombre', '$asociado_clave')";
		$res = $this->_conn->query($query);
        return mysqli_insert_id($this->_conn->getConnection());
	}

	/**
	 * update Recibe la informacion de un Asociados  y actualiza la informacion en la base de datos
	 * @param  array Array Array con la informacion con la cual se va a realizar la actualizacion en la base de datos
	 * @param  integer    identificador al cual se le va a realizar la actualizacion
	 * @return void
	 */
	public function update($data,$id){
		
		$asociado_nit = $data['asociado_nit'];
		$asociado_nombre = $data['asociado_nombre'];
    if($data['asociado_clave'] != ''){
      $asociado_clave = ', asociado_clave = "'.password_hash($data['asociado_clave'], PASSWORD_DEFAULT).'"';
    }
		$query = "UPDATE asociados SET  asociado_nit = '$asociado_nit', asociado_nombre = '$asociado_nombre' $asociado_clave WHERE asociado_id = '".$id."'";
		$res = $this->_conn->query($query);
	}
}