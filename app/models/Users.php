<?php

namespace Model;


/**
 * Users Model
 */
class Users extends BaseModel
{

	/** @var string */
	protected $primaryTable = 'users';



	/**
	 * @param int $id
	 * @return \Nette\Database\Table\ActiveRow or FALSE
	 */
	public function get($id)
	{
		return $this->table()->get($id);
	}



	/**
	 * @param mixed $key
	 * @param string|bool $value
	 * @return \Nette\Database\Table\ActiveRow or FALSE
	 */
	public function getBy($key, $value = FALSE)
	{
		if (is_array($key) OR $value === FALSE) {
			$where = $key;

		} else {
			$where = array($key => $value);
		}

		return $this->table()->where($where)->fetch();
	}

}
