<?php

use Nette\Config\Compiler;


/**
 * Model Extender
 * @author Michal Kos 
 */
class ModelsExtension extends Nette\Config\CompilerExtension
{
	
	public function loadConfiguration()
	{
		$container = $this->getContainerBuilder();
		$config = $this->getConfig();
		
		foreach ($config as $name => $params) {
			if (is_string($params)) {
				$class = $container->addDefinition($this->prefix($name))
					->setClass($params, array('@model'));

			} else {
				$class = $container->addDefinition($this->prefix($name))
					->setClass($params['class'], array('@model'));

				if (array_key_exists('context', $params) && $params['context']) {
					$class->addSetup('setContext');
				}

				if (array_key_exists('setup', $params) && is_array($params['setup'])) {
					foreach ($params['setup'] as $setup) {
						$class->addSetup($setup->value, Compiler::filterArguments($setup->attributes));
					}
				}

				if (array_key_exists('autowire', $params) && $params['autowire']) {
					$class->setAutowired(TRUE);
				} else {
					$class->setAutowired(FALSE);
				}

			}
		}
	}
	
}
