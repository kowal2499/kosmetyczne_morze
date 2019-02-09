<?php

namespace Base;

class Plugin extends \WP_Widget
{
    // ścieżka do zasobów
    private $assetsPath;

    // ścieżka do manfestu
    private $manifest;

    public function __construct() {
        parent::__construct('lanmer_widget', 'Lanmer Main', [
            'description' => 'Podstawowy plugin dla szablonu Lanmer',
        ]);

        $this->initialize();
    }

    private function initialize()
    {
        $this->assetsPath = plugins_url() . '/lanmer_main/assets/build/';
        $this->manifest = json_decode(file_get_contents($this->assetsPath . 'rev-manifest.json'), true);

        if (!$this->manifest) {
            throw new \Exception(__('Error decoding manifest file.', 'plugin-morze'));
        }

        Widget_Setup::getInstance()
            ->enqueue_style('app-styles', $this->getAsset('app.css'))
            ->enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin-ext')
            ->enqueue_style('slick-slider', plugins_url() . '/lanmer_main/node_modules/slick-carousel/slick/slick.css')

            ->enqueue_style('simple-lightbox', plugins_url() . '/lanmer_main/node_modules/simplelightbox/dist/simplelightbox.min.css')
            ->enqueue_style('font-awesome', plugins_url() . '/lanmer_main/node_modules/@fortawesome/fontawesome-free/css/all.min.css')

            ->enqueue_style_admin('admin-styles', plugins_url() . '/lanmer_main/assets/src/css/admin/admin.css')
            ->enqueue_script('jquery', plugins_url() . '/lanmer_main/node_modules/jquery/dist/jquery.js', null, '1.0.0', true)
            ->enqueue_script('slick-slider', plugins_url() . '/lanmer_main/node_modules/slick-carousel/slick/slick.js', null, '1.0.0', true)
            ->enqueue_script('simple-lightbox', plugins_url() . '/lanmer_main/node_modules/simplelightbox/dist/simple-lightbox.min.js', null, '1.0.0', true)
            ->enqueue_script('app-scripts', $this->getAsset('app.js'), null, '1.0.0', true, [
                'name' => '_settings',
                'data' => [
                    'url' => admin_url('admin-ajax.php')
                ]
            ])
            ->enqueue_script_admin('admin-scripts', plugins_url() . '/lanmer_main/assets/src/js/admin/admin.js', null, '1.0.0', true)
            ->add_actions();
    }

    private function getAsset($filename)
    {
        if (!$this->manifest) {
            return $this->assetsPath . $filename;
        } else {
            if (array_key_exists($filename, $this->manifest)) {
                // zwróć nazwę zasobu z hashem
                return $this->assetsPath . $this->manifest[$filename];
            } else {
                // nie ma go w pliku manifestu, więc zwróć po prostu nazwę
                return $this->assetsPath . $filename;
            }
        }
    }
}

class Lanmer_Main extends Plugin
{
    public function __construct()
    {
        parent::__construct();

        $this->adminSettings = \admin\Settings::getInstance();

        // add custom posts
        $this->treatments = \cpt\Treatments::getInstance();
        $this->staff = \cpt\Staff::getInstance();
        $this->galleries = \cpt\Gallery::getInstance();

        // register shortcodes
        add_shortcode('lanmer-hero', function() {
            return get_template_part( 'template-parts/content', 'home-hero' );
        });

        add_shortcode('lanmer-advatages-and-galleries', function() {
            return get_template_part( 'template-parts/content', 'home-advantages-and-galleries' );
        });

        add_shortcode('lanmer-staff', function() {
            return get_template_part( 'template-parts/content', 'home-staff' );
        });

        add_shortcode('lanmer-rules', function() {
            ob_start();
            get_template_part( 'template-parts/content', 'rules' );
            $retString = ob_get_contents();
            ob_end_clean();
            return $retString;
        });

        add_shortcode('logo', ['\admin\Functions', 'logo_shortcode']);
        add_shortcode('galeria', ['\admin\Functions', 'gallery_shortcode']);
        add_shortcode('time', ['\admin\Functions', 'time_shortcode']);

        // rejestruj ajaxy
        add_action('wp_ajax_nopriv_submit_message_form', ['\admin\Ajax', 'submit_message_form']);

        // funkcje
        add_filter('wp_get_nav_menu_items', ['\admin\Functions', 'exclude_nav_items'], null, 3);
        add_filter('wp_nav_menu_items', ['\admin\Functions', 'add_menu_logo'], null, 2);


        // specjalne ustawienia dla pętli w archiwum oferty
        add_action('pre_get_posts', ['\admin\Functions', 'lanmer_zabiegi_pre_get']);

        // not sure if this one works
        add_action('plugins_loaded', ['\admin\Functions', 'lanmer_load_textdomain']);

    }


}
