<?php

/**
 * Useful functions and shortcuts
 */

use Nette\Diagnostics\Debugger;



/**
 * PHP workaround for direct usage of created class
 *
 * <code>
 *  // echo (new Person)->name; // does not work in PHP
 *  echo c(new Person)->name;
 * </code>
 *
 * @param object $instance
 * @return object
 */
function c($instance)
{
	return $instance;
}



/**
 * PHP workaround for direct usage of cloned instances
 *
 * <code>
 *  echo cl($startTime)->modify('+1 day')->format('Y-m-d');
 * </code>
 *
 * @param object $instance
 * @return object
 */
function cl($instance)
{
	return clone $instance;
}



/**
 * @param $var
 * @return mixed
 */
function deepDump($var)
{
	$maxLen = Debugger::$maxLen;
	$maxDepth = Debugger::$maxDepth;

	Debugger::$maxLen = 4086;
	Debugger::$maxDepth = 8;

	foreach (func_get_args() as $arg) {
		Debugger::dump($arg);
	}

	Debugger::$maxLen = $maxLen;
	Debugger::$maxDepth = $maxDepth;

	return $var;
}



/**
 * Shortcut for Debugger::barDump
 * @param mixed $var
 * @param mixed $title optional title
 * @return mixed variable itself
 */
function barDump($var, $title = NULL)
{
	return Debugger::barDump($var, $title);
}



/**
 * Shortcut for Debugger::barDump
 * @param mixed $var
 * @param mixed $title optional title
 * @return mixed variable itself
 */
function deepBarDump($var, $title = NULL)
{
	$maxLen = Debugger::$maxLen;
	$maxDepth = Debugger::$maxDepth;

	Debugger::$maxLen = 4086;
	Debugger::$maxDepth = 8;

	$dump = Debugger::dump($var, $title);

	Debugger::$maxLen = $maxLen;
	Debugger::$maxDepth = $maxDepth;

	return $dump;
}
