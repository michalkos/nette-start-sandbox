<?php

namespace Model;

use Nette;


/**
 * Extend this when you are creating a Model
 * @author Michal Kos
 */
abstract class BaseModel extends Nette\Object
{
	
	/** @var \Model */
	public $model;
	
	/** @var \SystemContainer|\Nette\DI\Container */
	protected $context;
	
	/** @var bool */
	protected $modelStarted = FALSE;

	/** @var string */
	protected $primaryTable;
	
	
	
	/**
	 * ModelFactory Construct
	 * @param \Model $model
	 */
	public function __construct(\Model $model)
	{
		$this->model = $model;
		$this->startup();
	}
	
	
	
	/**
	 * This is always called after model initialization
	 */
	protected function startup()
	{
		$this->modelStarted = TRUE;
	}



	/**
	 * Set Context
	 * @param \Nette\DI\Container $context
	 */
	public function setContext(Nette\DI\Container $context)
	{
		$this->context = $context;
	}



	/**
	 * @param string $table
	 * @throws \Nette\UnexpectedValueException
	 * @return \Nette\Database\Table\Selection
	 */
	public function getTable($table = NULL)
	{
		if (empty($table)) {
			if ( ! isset($this->primaryTable)) {
				throw new Nette\UnexpectedValueException(__METHOD__ . ': Name of primary table is not set');
			}

			$table = $this->primaryTable;
		}

		return $this->model->table($table);
	}



	/**
	 * @param string $table
	 * @throws \Nette\UnexpectedValueException
	 * @return \Nette\Database\Table\Selection
	 */
	public function table($table = NULL)
	{
		return $this->getTable($table);
	}
	
}
