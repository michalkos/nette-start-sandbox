<?php

use Nette\Config\Configurator;


/**
 * Bootstrap class
 * @author Michal Kos
 */
class Bootstrap extends Nette\Object
{

	/** @var array */
	public $directories = array(
		'wwwDir' => NULL,
		'baseDir' => NULL,
		'appDir' => NULL,
		'libsDir' => NULL,
		'tempDir' => NULL,
		'logDir' => NULL
	);

	/** @var bool */
	public $enableDebugger = TRUE;

	/** @var array */
	public $autoload = array();

	/** @var bool */
	private $debugMode = FALSE;

	/** @var string */
	private $configurator = 'Nette\\Config\\Configurator';



	/**
	 * @param array $directories
	 * @return Bootstrap
	 */
	public function setDirectories(array $directories)
	{
		$this->directories = $directories;
		return $this;
	}



	/**
	 * @param bool $enable
	 * @return Bootstrap
	 */
	public function enableDebugger($enable = TRUE)
	{
		$this->enableDebugger = $enable;
		return $this;
	}



	/**
	 * @param bool $debugMode
	 * @return Bootstrap
	 */
	public function setDebugMode($debugMode = TRUE)
	{
		$this->debugMode = $debugMode;
		return $this;
	}



	/**
	 * @param string $configurator
	 * @return Bootstrap
	 */
	public function setConfigurator($configurator)
	{
		$this->configurator = $configurator;
		return $this;
	}



	protected function beforeCreateConfigurator()
	{
		foreach ($this->directories as $dir => $value) {
			$define = strtoupper(preg_replace('#(.)(?=[A-Z])#', '$1_', $dir));

			if (defined($define)) {
				if (empty($value)) {
					$this->directories[$dir] = constant($define);
				}

			} else {
				if (empty($value) && in_array($dir, array('tempDir', 'logDir'))) {
					$this->directories[$dir] = $value = $this->directories['baseDir'] . '/' . str_replace('Dir', '', $dir);

				} else {
					throw new Nette\UnexpectedValueException("Value of directory '$dir' has to be set");
				}

				define($define, $value);
			}
		}

		foreach (array('appDir', 'libsDir') as $dir) {
			if ( ! in_array($this->directories[$dir], $this->autoload)) {
				$this->autoload[] = $this->directories[$dir];
			}
		}
	}



	/**
	 * @return Nette\Config\Configurator
	 */
	public function createConfigurator()
	{
		$this->beforeCreateConfigurator();

		/** @var Configurator $configurator */
		$configurator = new $this->configurator;
		$configurator->addParameters(array('appDir' => $this->directories['appDir']));

		if ($this->debugMode) {
			$configurator->setDebugMode();
		}

		if ($this->enableDebugger) {
			$configurator->enableDebugger($this->directories['logDir']);
		}

		$configurator->setTempDirectory($this->directories['tempDir']);
		$configurator->createRobotLoader()
			->addDirectory($this->autoload)
			->register();

		$configurator->onCompile[] = function($configurator, $compiler) {
			$compiler->addExtension('models', new ModelsExtension);
		};

		return $configurator;
	}



	/**
	 * @param Nette\Config\Configurator $configurator
	 * @return \SystemContainer
	 */
	public function createContainer(Configurator $configurator = NULL)
	{
		if (empty($configurator)) {
			$configurator = $this->createConfigurator();

			$configurator->addConfig($this->directories['appDir'] . '/config/config.neon',
				$this->debugMode ? $configurator::DEVELOPMENT : $configurator::AUTO
			);
		}

		return $configurator->createContainer();
	}

}
