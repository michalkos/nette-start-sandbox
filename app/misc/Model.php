<?php

/**
 * Basic Model class
 * @author Michal Kos
 */
class Model extends Nette\Object
{
	
	/** @var Nette\Database\Connection */
	protected $db;
	
	
	/**
	 * @param Nette\Database\Connection $database
	 */
	public function __construct(Nette\Database\Connection $database)
	{
		$this->db = $database;
	}
	
	
	
	/**
	 * @return Nette\Database\Connection 
	 */
	public function getConnection()
	{
		return $this->db;
	}



	/**
	 * Load Model
	 * @param string $name Class name
	 * @return \Model\BaseModel
	 */
	public function loadModel($name)
	{
		$name = ucfirst($name);
		$class = 'Model\\' . $name;
		
		if (class_exists($class)) {
			$model = new $class($this);
		} else {
			$model = new $name($this);
		}
		
		return $model;
	}
	
	
	
	/**
	 * @param string $table Table name
	 * @return Nette\Database\Table\Selection
	 */
	public function table($table)
	{
		return $this->db->table($table);
	}
	
	
	
	/**
	 * @param string $sql
	 * @return Nette\Database\Statement
	 */
	public function query($sql)
	{
		$args = func_get_args();
		return $this->db->queryArgs(array_shift($args), $args);
	}
	
	
	
	/**
	 * Insert new row
	 * @param string $table
	 * @param array $values
	 * @return Nette\Database\Table\ActiveRow|FALSE 
	 */
	public function insert($table, $values)
	{
		return $this->table($table)->insert($values);
	}
	
	
	
	/**
	 * Update a row
	 * @param string $table
	 * @param array $values
	 * @param array|int $where
	 * @param string $primaryKey
	 * @return int number of affected rows or FALSE in case of an error
	 */
	public function update($table, $values, $where = NULL, $primaryKey = 'id')
	{
		if(is_null($where)) {
			return $this->table($table)->update($values);
			
		} else {
			if(is_int($where) && $where > 0) {
				$where = array($primaryKey => $where);
			}
			
			return $this->table($table)->where($where)->update($values);
		}
	}
	
	
	
	/**
	 * Delete a row
	 * @param string $table
	 * @param array|int $where
	 * @param string $primaryKey
	 * @return int number of affected rows or FALSE in case of an error
	 */
	public function delete($table, $where, $primaryKey = 'id')
	{
		if(is_int($where) && $where > 0) {
			$where = array($primaryKey => $where);
		}
		
		return $this->table($table)->where($where)->delete();
	}
	

}