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
 * Twig Module Configs
 *
 * @filesource
 */
return array(

    /**
     * Twig Loader options
     */
    'loader' => array(
        'extension' => 'twig',  // Extension for Twig files
        'path'      => 'views', // Path within cascading filesystem for Twig files
    ),

    /**
     * Twig Environment options
     *
     * http://twig.sensiolabs.org/doc/api.html#environment-options
     */
    'environment' => array(
        'debug'				  => (Kohana::$environment == Kohana::DEVELOPMENT),
        'charset'             => 'utf-8',
        'base_template_class' => 'Twig_Template',
        'cache'               => APPPATH.'cache/twig',
        'auto_reload'         => (Kohana::$environment == Kohana::DEVELOPMENT),
        'strict_variables'    => false,
        'autoescape'          => true,
        'optimizations'       => -1,
    ),

    /**
     * Custom functions, filters and tests
     *
     *     'functions' => array(
     *         array('my_method', array('MyClass', 'my_method'), array('is_safe' => array('html'))),
     *     ),
     */
    'functions' => array(),
    'filters' => array(),
    'tests' => array(),
);