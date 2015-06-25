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
 * Class Kohana_Twig
 */
class Kohana_Twig extends View {

    /**
     * @var Kohana_Config_Group
     */
    public static $config;

    /**
     * @var Twig_Environment
     */
    protected static $_environment;

    /**
     * Initialize Twig Module
     *
     * @throws Kohana_Exception
     */
    public static function init()
    {
        // Register auto loader
        Twig_Autoloader::register();

        // Load Config
        Twig::$config = Kohana::$config->load('twig');

        // Initialize path
        $path = Twig::$config['environment']['cache'];
        if ( ! is_dir($path) && ! is_writable($path) && ! self::_init_cache($path))
        {
            throw new Twig_Exception('Directory :dir must exists and be writable', array(
                ':dir' => Debug::path($path)
            ));
        }
    }

    // ----------------------------------------------------------------------

    /**
     * Create a Twig view instance
     *
     * @param string $file Name of view without extension.
     * @param array $data Data to be passed to view
     * @return Twig
     */
    public static function factory($file = null, array $data = null)
    {
        return new Twig($file, $data);
    }

    // ----------------------------------------------------------------------

    /**
     * Get the Twig environment
     *
     * @return Twig_Environment
     */
    public static function environment()
    {
        // Create it on first call
        if (Twig::$_environment == null)
        {
            Twig::$_environment = self::_init_env();
        }

        return Twig::$_environment;
    }

    // ----------------------------------------------------------------------

    /**
     * Initialize the cache directory
     *
     * @param string $path
     * @return bool
     */
    protected static function _init_cache($path)
    {
        if(mkdir($path, 02777, true) && chmod($path, 02777))
            return true;

        return false;
    }

    // ----------------------------------------------------------------------

    /**
     * Create a new Twig environment
     *
     * @return Twig_Environment
     */
    protected static function _init_env()
    {
        // Instance of Environment
        $env = new Twig_Environment(
            new Twig_loader_CFS(Twig::$config['loader']),
            Twig::$config['environment']
        );

        // Functions
        if ( ! empty(Twig::$config['functions']))
        {
            foreach (Twig::$config['functions'] as $name => $callable)
            {
                $function = new Twig_SimpleFunction($name, $callable);
                $env->addFunction($function);
            }
        }

        // Filters
        if ( ! empty(Twig::$config['filters']))
        {
            foreach (Twig::$config['filters'] as $name => $callable)
            {
                $filter = new Twig_SimpleFilter($name, $callable);
                $env->addFilter($filter);
            }
        }

        // Tests
        if ( ! empty(Twig::$config['tests']))
        {
            foreach (Twig::$config['tests'] as $name => $callable)
            {
                $test = new Twig_SimpleTest($name, $callable);
                $env->addTest($test);
            }
        }

        // Debug
        if (Twig::$config['environment']['debug'] === true)
        {
            $env->addExtension(new Twig_Extension_Debug());
        }

        return $env;
    }

    // ----------------------------------------------------------------------

    /**
     * Set the filename for the Twig view
     *
     * @param string $file Base name of view without extension
     * @return $this
     */
    public function set_filename($file)
    {
        $this->_file = $file;

        return $this;
    }

    // ----------------------------------------------------------------------

    /**
     * Get the filename for Twig view
     *
     * @return mixed
     */
    public function get_filename()
    {
        return $this->_file;
    }

    // ----------------------------------------------------------------------

    public function render($file = null)
    {
        if ($file !== NULL)
        {
            $this->set_filename($file);
        }

        if (empty($this->_file))
        {
            throw new Twig_Exception('You must set the file to use within your view before rendering');
        }

        // Get environment
        $twig = Twig::environment();

        // Globals
        if ( ! empty(Twig::$_global_data))
        {
            foreach (Twig::$_global_data as $name => $value)
            {
                $twig->addGlobal($name, $value);
            }
        }

        // Return a rendered view
        return $twig->render($this->_file, $this->_data);
    }
}