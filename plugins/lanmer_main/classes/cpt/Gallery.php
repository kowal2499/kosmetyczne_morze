<?php
namespace cpt;

class Gallery extends CustomPost
{
    private static $instance;

    public $id;
    public $title;
    public $galleryItems;
    public $description;
    public $orientation;
    public $category;

    protected function __construct()
    {
        if (!self::$instance) {

            // custom taxonomy

            add_action('init', function () {
                register_taxonomy(
                    'gallery',
                    'rk_gallery',
                    [
                        'label' => __('Miejsce na stronie'),
                        'rewrite' => ['slug' => 'gallery'],
                        'hierarchical' => true,
                        'publicly_queryable' => false

                    ]
                );
            });

            $this->name = 'rk_gallery';

            $this->names = [
                'name' => __('Galerie', 'lanmer-cpt'),
                'singular_name' => 'Galeria',
                'add_new' => 'Dodaj nową galerię',
                'all_items' => 'Wszystkie galerie'
            ];

            $this->args = [
                'can_export' => true,
                'exclude_from_search' => true,
                'publicly_queryable' => false,
                'query_var' => 'rk_gallery',
                'public' => false,
                'has_archive' => false,
                'supports' => ['title', 'custom_fields'],
                'menu_position' => 5,
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'taxonomies' => ['gallery']
            ];

            $this->metaboxes = [
                [
                    'name' => 'Galeria',
                    'manager' => new \admin\InputManager(plugin_dir_path(__DIR__)
                        . '../conf/inputs_gallery.json')
                ]
            ];

            parent::__construct();
        }
    }

    public function findAll($search) {

        $query = [
            'post_type' => $this->name,
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
        ];

        if (in_array('id', array_keys($search))) {
            $query['post__in'] = (array) $search['id'];
        }

        $q = new \WP_Query($query);

        $findings = [];

        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $id = get_the_id();

                /**
                 * Sprawdź czy post jest z określonej kategorii
                 */
                $category = get_the_terms($id, 'gallery')[0]->name;
                if (isset($search['customCategory']) && ($category != $search['customCategory'])) {
                    continue;
                }

                $gallery = array_map(function ($item) use ($id) {
                    return [
                        'id' => $item['galleryItem'],
                        'url' => wp_get_attachment_url($item['galleryItem']),
                    ];
                }, get_post_meta($id, 'lanmerGallery')[0]);

                $item = new self();
                $item->id = $id;
                $item->title = get_the_title();
                $item->galleryItems = $gallery;
                $item->description = get_post_meta($id, 'description')[0];
                $item->orientation = get_post_meta($id, 'orientation')[0];
                $item->category = $category;
                $findings[] = $item;

            }
        }
        wp_reset_query();
        return $findings;
    }

    public function render()
    {
        $counter = 0;
        $new = '<div class="col-sm-4 ">';
        $new .= '<ul class="bubble-gallery">';
            foreach ($this->galleryItems as $g) {
                switch ($counter) {
                    case 0:
                    case 1:
                        $new .= '<li class="bubble-gallery-item"><a class="gallery" href="' . wp_get_attachment_image_src($g['id'], 'full')[0] . '" data-galleryId="' . $this->id. '"><img class="img-circle big" src="' . wp_get_attachment_image_src($g['id'], 'thumbnail')[0] . '" alt=""></a></li>';
                        break;
                    case 2:
                        $new .= '<li class="bubble-gallery-item show-more"><a class="gallery" href="' . wp_get_attachment_image_src($g['id'], 'full')[0] . '" data-galleryId="' . $this->id. '">';
                        $new .= '<i class="fas fa-search-plus"></i>';
                        $new .= '</a></li>';
                        break;
                    default:
                        $new .= '<a class="hidden gallery" href="' . wp_get_attachment_image_src($g['id'], 'full')[0] . '" data-galleryId="' . $this->id . '"></a>';
                }
                $counter++;
            }
        $new .= '</ul>';
        $new .= '</div>';

        $sideB = '<div class="col-sm-8">
                    <h2>' . $this->title . '</h2>
                    <img src="' . plugins_url() . '/lanmer_main/assets/imgs/logo-dark-tiny.png' . '" alt="Morze SPA małe logo" class="small-logo">
                    <p class="description">' . $this->description . '</p>
                </div>';
        if ($this->orientation == '1') {
            return  '<div class="row"><div class="hh-gallery">' . $new . $sideB . '</div></div>';
        } else {
            return '<div class="row"><div class="hh-gallery">' . $sideB . $new . '</div></div>';
        }
    }

    public function renderSimple()
    {
        echo '<div class="simpleGallery">';
        echo '<div class="wrapper">';
        foreach ($this->galleryItems as $index => $g) {
            echo '<a href="' . wp_get_attachment_image_src($g['id'], 'full')[0] . '" data-galleryId="' . $this->id . '" style="left: ' . (0 * $index * 40). 'px">';
            echo '<img src="' . wp_get_attachment_image_src($g['id'], 'thumbnail')[0] . '">';
            echo '</a>';
        }
        echo '</div>';
        echo '</div>';
    }

    /**
     * Galeria jako content postu
     */
    public function renderContent()
    {

        $content = '';

        switch ($this->orientation) {

            case 1:
                $content = $this->renderImagesWithText(false);
                break;

            case 2:
                $content = $this->renderImagesWithText(true);
                break;

            case 5:
                $content = $this->renderBrands();
                break;

            default:
                $content = $this->renderDefault();
        }

        return '<div class="simpleGallery">' . $content . '</div>';
    }

    private function renderImagesWithText($textFirst = true)
    {

        $t = '';
        $t .= '<div class="row">';

        $t .= '<div class="wrapper">';
        $tText = '<div class="textArea widthLimit">' . $this->renderText() . '</div>';

        $tImages = '<div class="imagesArea widthLimit">';
        foreach ($this->galleryItems as $index => $g) {
            $tImages .= '<a href="' . wp_get_attachment_image_src($g['id'], 'full')[0] . '" data-galleryId="' . $this->id . '" class="gallery">';
            $tImages .= '<img src="' . wp_get_attachment_image_src($g['id'], 'thumbnail')[0] . '">';
            $tImages .= '</a>';
        }
        $tImages .= '</div>';

        if ($textFirst) {
            $t .= $tText . $tImages;
        } else {
            $t .= $tImages . $tText;
        }

        $t .= '</div>';

        $t .= '</div>';

        return $t;
    }

    private function renderBrands()
    {
        $t = '';
        $t .= '<div class="row">';

        $t .= '<div class="wrapperBrands">';

        $t .= '<div class="textArea text-center">' . $this->renderText() . '</div>';

        $t .= '<div class="imagesArea">';
        foreach ($this->galleryItems as $index => $g) {
            $t .= '<img src="' . wp_get_attachment_image_src($g['id'], 'full')[0] . '">';
        }
        $t .= '</div>';

        $t .= '</div>';
        $t .= '</div>';

        return $t;

    }

    private function renderDefault()
    {
        $ret = '<div class="content-gallery">';
        $ret .= '<div class="grid">';

        foreach($this->galleryItems as $item) {
            $ret .= '<div class="cell">';
            $ret .= '<a class="gallery" href="' . wp_get_attachment_image_src($item['id'], 'full')[0] . '" data-galleryId="' . $this->id . '"><img src="' . wp_get_attachment_image_src($item['id'], 'thumbnail')[0] . '" class="responsive-image"></a>';
            $ret .= '</div>';
        }
        $ret .= '</div>';
        $ret .= '</div>';

        return $ret;
    }

    private function renderText()
    {
        $t = '';
        $t .= '<h2>' . $this->title . '</h2>';
        $t .= '<div class="logo"></div>';
        $t .= '<p class="description">' . $this->description . '</p>';

        return $t;
    }

    protected function beforeMetaBox()
    {
        $result = '';
        if ($_GET['post']) {
            $result = '<strong>\'Shortcode\' do umieszczenia wewnątrz wpisu dla tej galerii: </strong>' . '<br>' . '[galeria id="' . $_GET['post'] . '"]' . '<hr>';
        }
        return $result;
    }
    
    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}