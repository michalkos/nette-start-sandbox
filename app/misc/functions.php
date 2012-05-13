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
 * @param mixed $var
 * @param int $maxLen
 * @param int $maxDepth
 * @return mixed
 */
function deepDump($var, $maxLen = 4086, $maxDepth = 8)
{
	$prev_maxLen = Debugger::$maxLen;
	$prev_maxDepth = Debugger::$maxDepth;
	Debugger::$maxLen = $maxLen;
	Debugger::$maxDepth = $maxDepth;

	foreach (func_get_args() as $arg) {
		Debugger::dump($arg);
	}

	Debugger::$maxLen = $prev_maxLen;
	Debugger::$maxDepth = $prev_maxDepth;

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
 * @param int $maxLen
 * @param int $maxDepth
 * @return mixed variable itself
 */
function deepBarDump($var, $title = NULL, $maxLen = 4086, $maxDepth = 8)
{
	$prev_maxLen = Debugger::$maxLen;
	$prev_maxDepth = Debugger::$maxDepth;
	Debugger::$maxLen = $maxLen;
	Debugger::$maxDepth = $maxDepth;

	$dump = Debugger::barDump($var, $title);

	Debugger::$maxLen = $prev_maxLen;
	Debugger::$maxDepth = $prev_maxDepth;

	return $dump;
}
