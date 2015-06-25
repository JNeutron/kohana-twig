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
class Kohana_Twig_Loader {

    /**
     * Auto load Twig vendor classes
     *
     * @param string $class Class name
     * @return bool
     */
    public static function auto_load($class)
    {
        $parts = explode('_', $class);

        // It is not a Twig class
        if ($parts[0] != 'Twig')
            return false;

        // Twig library path
        $filename = MODULE_TWIG_PATH
            .'vendor'.DIRECTORY_SEPARATOR
            .'Twig'.DIRECTORY_SEPARATOR
            .'lib'.DIRECTORY_SEPARATOR;

        // Compose filename
        $filename .= implode(DIRECTORY_SEPARATOR, $parts);
        $filename .= EXT;

        // Is a valid file
        if (is_file($filename))
        {
            require $filename;

            return true;
        }

        return false;
    }
}