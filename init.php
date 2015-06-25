<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Twig Module
 *
 * @author      Iván Molina Pavana <montemolina@live.com>
 * @copyright   Copyright (c) 2015
 * @version     1.0.0
 */

// --------------------------------------------------------------------------------

/**
 * Initialize Twig Module
 *
 * @filesource
 */

/*
 * ------------------------------------------------------------
 * Module Directory
 * ------------------------------------------------------------
 */
    define('MODULE_TWIG_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

/*
 * ------------------------------------------------------------
 * Register a Twig auto loader
 * ------------------------------------------------------------
 */
    spl_autoload_register(array('Twig_Loader', 'auto_load'));

/*
 * ------------------------------------------------------------
 * Initialize module
 * ------------------------------------------------------------
 */
    Twig::init();