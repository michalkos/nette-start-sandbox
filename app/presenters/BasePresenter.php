<?php

/**
 * Base class for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var \Model */
	public $model;

	/** @var \SystemContainer_models */
	public $models;


	protected function startup()
	{
		parent::startup();

		$this->model = $this->getContext()->model;
		$this->models = $this->getContext()->models;
	}

}
