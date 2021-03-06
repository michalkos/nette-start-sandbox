<?php

/**
 * Basic Model class
 * @author Michal Kos
 */
class Model extends Nette\Object
{
	
	/** @var Nette\Database\Connection */
	protected $connection;

	/** @var bool Use camel table name with __call. e.q. usersData converts to users_data */
	public $useCamelTableCall = TRUE;


	
	/**
	 * @param Nette\Database\Connection $connection
	 */
	public function __construct(Nette\Database\Connection $connection)
	{
		$this->connection = $connection;
	}
	
	
	
	/**
	 * @return Nette\Database\Connection 
	 */
	public function getConnection()
	{
		return $this->connection;
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
		return $this->connection->table($table);
	}
	
	
	
	/**
	 * @param string $sql
	 * @return Nette\Database\Statement
	 */
	public function query($sql)
	{
		$args = func_get_args();
		return $this->connection->queryArgs(array_shift($args), $args);
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
		if (is_null($where)) {
			return $this->table($table)->update($values);
			
		} else {
			if (is_int($where) && $where > 0) {
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
		if (is_int($where) && $where > 0) {
			$where = array($primaryKey => $where);
		}
		
		return $this->table($table)->where($where)->delete();
	}



	/**
	 * @param string $name
	 * @param array $args
	 * @return Nette\Database\Table\Selection
	 */
	public function __call($name, $args)
	{
		if ($this->useCamelTableCall) {
			$name = preg_replace('#(.)(?=[A-Z])#', '$1_', $name);
			$name = strtolower($name);
		}

		$selection = $this->table($name);

		$argsCount = count($args);
		if ($argsCount == 1) {
			if (is_int($args[0])) {
				$selection = $selection->where($selection->getPrimary(), $args[0]);

			} elseif (is_array($args[0])) {
				$selection = $selection->where($args[0]);
			}

		} elseif ($argsCount == 2) {
			$selection = $selection->where($args[0], $args[1]);
		}

		return $selection;
	}

}