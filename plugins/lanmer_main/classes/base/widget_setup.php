<?php

namespace Base;

class Widget_Setup {

    private static $instance;
    
    private $front_styles = array();
    private $admin_styles = array();
    private $front_scripts = array();
    private $admin_scripts = array();


    private function __construct() {}

    static public function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new Widget_Setup;
        }
        return self::$instance;
    }

    public function enqueue_style($handle, $src, $deps=array(), $version='1.0', $media='all') {
        $this->front_styles[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'version' => $version,
            'media' => $media
        );
        return self::$instance;
    }

    public function enqueue_style_admin($handle, $src, $deps=array(), $version='1.0', $media='all') {
        $this->admin_styles[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'version' => $version,
            'media' => $media
        );
        return self::$instance;
    }

    public function enqueue_script($handle, $src, $deps=array(), $version='1.0', $inFooter=true, $localize=array()) {
        $this->front_scripts[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'version' => $version,
            'inFooter' => $inFooter,
            'localize' => $localize
        );
        return self::$instance;
    }

    public function enqueue_script_admin($handle, $src, $deps=array(), $version='1.0', $inFooter=true, $localize=array()) {
        $this->admin_scripts[] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'version' => $version,
            'inFooter' => $inFooter,
            'localize' => $localize
        );
        return self::$instance;
    }

    public function debug() {
        var_dump($this->front_scripts);
    }

    
    public function add_actions() {
        if (is_admin() == true) {
            // die();
        }
        // odpal style
        add_action('wp_enqueue_scripts', function () {
            foreach ($this->front_styles as $style) {
                wp_enqueue_style(
                    $style['handle'],
                    $style['src'],
                    $style['deps'],
                    $style['version'],
                    $style['media']
                );
            }
            return true;
        });
        // odpal skrypty
        add_action('wp_enqueue_scripts', function () {
            if (is_admin()) return;
            $scripts = $this->front_scripts;

            foreach ($scripts as $script) {

                wp_register_script(
                    $script['handle'],
                    $script['src'],
                    $script['deps'],
                    $script['version'],
                    $script['inFooter']
                );

//                // set variables for script
//                wp_localize_script('appascripts', '__wariables', [
//                    'send_label' => 123
//                ]);

                wp_enqueue_script(
                    $script['handle']
                );

                if (!empty($script['localize'])) {
                    // set variables for script
                    wp_localize_script(
                        $script['handle'],
                        $script['localize']['name'],
                        $script['localize']['data']
                    );
                }
            }
            return true;
        });

        // odpal style admina
        add_action('admin_enqueue_scripts', function () {
            foreach ($this->admin_styles as $style) {
                wp_enqueue_style(
                    $style['handle'],
                    $style['src']
                );
            }
            return true;
        });

        // odpal skrypty admina
        add_action('admin_enqueue_scripts', function () {
            if (!is_admin()) {
                return;
            }
            $scripts = $this->admin_scripts;

            foreach ($scripts as $script) {
                wp_enqueue_script(
                    $script['handle'],
                    $script['src'],
                    $script['deps'],
                    $script['version'],
                    $script['inFooter']
                );
            }

            wp_enqueue_media();

            return true;
        });

    }

}
