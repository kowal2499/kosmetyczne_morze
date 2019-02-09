<?php
namespace cpt;

class Staff extends CustomPost
{
    private static $instance;

    protected function __construct()
    {
        $this->name = 'pracownicy';

        $this->names = [
            'name'              => __('Pracownicy', 'lanmer-cpt'),
            'singular_name'     => 'pracownik',
            'add_new'           => 'Dodaj nowego pracownika',
            'all_items'         => 'Wszyscy pracownicy'
        ];

        $this->args = [
            'can_export'            => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'query_var'             => 'pracownicy',
            'rewrite'               => ['slug' => 'pracownicy'],
            'public'                => true,
            'has_archive'           => true,
            'supports'              => ['title', 'editor', 'custom_fields'],
            'menu_position'         => 6,
            'hierarchical'          => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
        ];

        $this->metaboxes = [];

        
        
        $this->metaboxes = [
            [
                'name' =>  'Zdjęcie & dane kontaktowe',
                'manager' => new \admin\InputManager(plugin_dir_path(__DIR__)
                    . '../conf/inputs_staff.json')
            ]
        ];
        

        parent::__construct();

    }

    public function findAll() {
        $q = new \WP_Query(
            [
                'post_type' => $this->name,
                'posts_per_page' => -1,
                'order' => 'ASC',
            ]
        );

        $result = [];

        if ($q->have_posts()) {
            while ($q->have_posts()) {
                $q->the_post();
                $id = get_the_id();

                /**
                 * Sprawdź czy post jest z określonej kategorii
                 */

                $result[] = [
                    'id' => $id,
                    'title' => get_the_title(),
                    'content' => get_the_content(),
                    'photo' => get_post_meta($id, 'photo')[0],
                    'contacts' => get_post_meta($id, 'contacts')[0],
                ];
            }
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