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
 * Class Kohana_Twig_Loader
 */
class Kohana_Twig_Loader_CFS implements Twig_LoaderInterface {

    /**
     * @var array Loader Config
     */
    protected $_config;

    /**
     * Constructor
     *
     * @param array $config Loader configuration
     */
    public function __construct(array $config)
    {
        $this->_config = $config;
    }

    // ----------------------------------------------------------------------

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     * @return string The template source code
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        return file_get_contents($this->find_file($name));
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     * @return string The cache key
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($name)
    {
        return $name;
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time Timestamp of the last modification time of the cached template
     * @return bool true if the template is fresh, false otherwise
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        return filemtime($this->find_file($name)) <= $time;
    }

    // ----------------------------------------------------------------------

    /**
     * Find a view file in the cascading filesystem
     *
     * @param string $file File name or file with absolute path.
     * @return string
     * @throws Twig_Error_Loader
     */
    public function find_file($file)
    {
        // We can pass the file directly
        if (is_file($file))
            return $file;

        // Find file in Kohana directories
        $file = Kohana::find_file($this->_config['path'], $file, $this->_config['extension']);
        if ( ! is_file($file))
        {
            throw new Twig_Error_Loader(
                __('The requested view :file could not be found.', array(
                    ':file' => str_replace(MODPATH, '', $file)
                ))
            );
        }

        return $file;
    }
}