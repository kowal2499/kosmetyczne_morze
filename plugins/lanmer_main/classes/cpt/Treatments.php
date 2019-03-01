<?php
namespace cpt;

class Treatments extends CustomPost
{
    private static $instance;

    /**
     * wszystkie zabiegi w formie zagnieżdżonej listy
     */
    protected $tree;

    /**
     * wszystkie zabiegi w formie mapy poziomów
     */
    protected $levelMap;

    /**
     * Wszystkie posty wg id
     */
    protected $allPosts = [];

    /**
     * Lista html z kategoriami do menu
     */
    protected $htmlMenu;
    public $taxonomy;

    protected function __construct()
    {
        $this->name = 'zabiegi';
        $this->taxonomy = 'kategoria';

        // register taxonomy
        register_taxonomy($this->taxonomy, $this->name, [
            'hierarchical' => true,
            'query_var' => true,
            'label' => __('Kategorie zabiegów', 'lanmer-cpt'),
            'query_var' => true,
            'rewrite' => [
                'slug' => $this->taxonomy,
            ]
        ]);

        $this->names = [
            'name'              => __('Zabiegi', 'lanmer-cpt'),
            'singular_name'     => 'Zabieg',
            'add_new'           => __('Dodaj nowy zabieg', 'lanmer-cpt'),
            'all_items'         => __('Wszystkie zabiegi', 'lanmer-cpt')
        ];

        $this->args = [
            'can_export'            => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'query_var'             => 'zabiegi',
            'public'                => true,
            'has_archive'           => true,
            'rewrite'               => ['slug' => 'zabieg'],
            'supports'              => ['title', 'editor', 'excerpt', 'page-attributes', 'custom_fields'],
            'menu_position'         => 5,
            'hierarchical'          => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'taxonomies'            => [$this->taxonomy]
        ];

        $this->metaboxes = [];

        $this->metaboxes = [
            [
                'name' =>  'Zdjęcia, Cennik',
                'manager' => new \admin\InputManager(plugin_dir_path(__DIR__)
                    . '../conf/inputs_treatments.json')
            ]
        ];

        parent::__construct();

        // filtr w panelu administracyjnym
        add_action('restrict_manage_posts', function($post_type, $which) {

            if ($post_type !== $this->name) {
                return;
            }
            $taxonomy_obj = get_taxonomy($this->taxonomy);
            $taxonomy_name = $taxonomy_obj->labels->name;
            $terms = get_terms($this->taxonomy);

            echo "<select name='{$this->taxonomy}' id='{$this->taxonomy}' class='postform' style='max-width: 350px'>";
            echo '<option value="">Wszystkie ' . strtolower($taxonomy_obj->labels->name) . '</option>';
            foreach ($terms as $term) {
                printf(
                    '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                    $term->slug,
                    ( ( isset( $_GET[$this->taxonomy] ) && ( $_GET[$this->taxonomy] == $term->slug ) ) ? ' selected="selected"' : '' ),
                    $term->name,
                    $term->count
                );
            }
            echo '</select>';
        } , 10, 2);

        // kolumny w panelu administracyjnym
        add_filter('manage_zabiegi_posts_columns', function($columns) {

            $newCols = [
                'cb' => $columns['cb'],
                'title' => $columns['title'],
            ];
            unset($columns['cb']);
            unset($columns['title']);

            $newCols[$this->taxonomy] = __('Kategoria zabiegu', 'lanmer-cpt');

            return array_merge($newCols, $columns);
        });

        // treść kolumny
        add_action( 'manage_zabiegi_posts_custom_column' , function($column, $post_id) {
            switch ( $column ) {
                case $this->taxonomy:
                    $terms = get_the_term_list($post_id , $this->taxonomy , '' , ',' , '');
                    if ( is_string( $terms ) )
                        echo $terms;
                    else
                        echo __('brak', 'lanmer-cpt');
                    break;
            }
        }, 10, 2 );

//        $this->getCategories(0, $this->tree, $this->levelMap);

    }

    /**
     * Dodaje pozycje zabiegów do menu
     */
    public function addItemsToMenu($items, $args)
    {
        if ($args->theme_location != 'menu-1') {
            return $items;
        }
        $html = $this->getHTMLList($this->tree);
        // oczyść html-a menu
        $html = preg_replace('/^<ul>|$<\/ul>/', '', $html);
        return $items . $html;
    }

    /**
     * Zwraca drzewo zabiegów
     * 
     * @return array
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Zwraca mapę poziomów
     * 
     * @return array
     */
    public function getLevelsMap()
    {
        return $this->levelMap;
    }

    public function findAll($search = [])
    {
        $query = array_merge([
            'post_type' => $this->name,
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
        ], $search);

        $q = new \WP_Query($query);

        $findings = [];
        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $findings[] = get_the_id();
            }
        }
        wp_reset_query();
        return $findings;
    }

    /**
     * Zwraca posty
     * 
     * @return array
     */
    public function getAllPosts()
    {
        return $this->allPosts;
    }
    
    /**
     * Uruchamia rekurencyjne tworzenie listy HTML
     */
    public function getHTMLList()
    {
        return $this->parseToHTML($this->tree);
    }

    /**
     * Rekurencyjne przechodzi przez drzewo zabiegów i buduje listę HTML
     */
    private function parseToHTML($array, $html = '')
    {
        if (!empty($array)) {
            $html .= '<ul>';
            foreach ($array as $record) {
                $html .= '<li>';
                $html .= '<a href="' . $record['link'] . '">' . $record['post']['post_title'] . '</a>';

                $inner = [];
                if (isset($record['childs'])) {
                    $html = $this->parseToHTML($record['childs'], $html);
                }
            
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    /**
     * 
     */
//    private function getCategories($parent, &$tree, &$levelMap, $level=0)
//    {
//        $q = new \WP_Query(
//            [
//                'post_type' => $this->name,
//                'posts_per_page' => -1,
//                'post_parent' => $parent,
//                'order' => 'ASC',
//                'orderby' => 'menu_order'
//            ]
//        );
//
//        $posts = [];
//
//        if ($q->have_posts()) {
//
//            $thisLevel = [];
//
//            while ($q->have_posts()) {
//                $q->the_post();
//
//                $id = get_the_id();
//
//                $levelMap[$level][$parent][] = $id;
//
//                $tree[$id] = [
//                    'post' => get_post(null, ARRAY_A),
//                    'link' => get_the_permalink(),
//                    'childs' => []
//                ];
//
//                $this->allPosts[$id] = [
//                    'post' => get_post(null, ARRAY_A),
//                    'link' => get_the_permalink(),
//                ];
//
//                $this->getCategories($id, $tree[$id]['childs'], $levelMap, $level+1);
//
//            }
//
//        }
//        wp_reset_query();
//    }

    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

}