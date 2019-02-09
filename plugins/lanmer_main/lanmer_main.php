<?php
/**
 * Plugin Name: Kosmetyczne Morze - główna wtyczka
 */

/**
 *  AUTOLOADER 
 */

\spl_autoload_register(function($classname) {
    $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $classname . '.php';

    if (file_exists($file)) {
        require_once($file);
    } else {
        if (file_exists(strtolower($file))) {
            require_once(strtolower($file));
        }
    }
});



/**
 *  INITIALIZE PLUGIN
 */

function lanmer_load_widget()
{
    try {
        register_widget('\Base\Lanmer_Main');
    } catch (\Exception $e) {
        // TODO: redirect to error page here
        wp_die($e->getMessage());
    }
}

add_action('widgets_init', 'lanmer_load_widget');


