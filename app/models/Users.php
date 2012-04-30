<?php

namespace Model;


/**
 * Users Model
 */
class Users extends BaseModel
{

	/**
	 * @param int $id
	 * @return \Nette\Database\Table\ActiveRow or FALSE
	 */
	public function get($id)
	{
		return $this->model->table('users')->get($id);
	}

}
