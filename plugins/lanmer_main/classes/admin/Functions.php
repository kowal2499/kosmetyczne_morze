<?php
/**
 * Created by PhpStorm.
 * User: Romek
 * Date: 22.10.2018
 * Time: 21:19
 */

namespace admin;


use cpt\Gallery;

class Functions
{
    /**
     * Usuwa elementy z menu na stronie główej. Lista elementów definiowana w ustawieniach.
     *
     * @param $items
     * @param $menu
     * @param $args
     * @return mixed
     */
    public static function exclude_nav_items( $items, $menu, $args ) {

        if (is_front_page()) {

            $excludesString = get_option(Settings::MENU_ITEMS_HIDE);

            if ($excludesString) {
                foreach ($items as $key => $item) {

                    $excludesArray = explode(',', strtoupper(get_option(Settings::MENU_ITEMS_HIDE)));
                    $excludesArray = array_map(function($item) { return trim($item); }, $excludesArray);

                    if (in_array(strtoupper($item->title), $excludesArray)) {
//                        unset($items[$key]);
                        $item->classes[] = 'item-hidden';
                    }
                }
            }
        }
        return $items;
    }

    /**
     * Dodaje logo do menu
     *
     * @param $item
     * @param $args
     * @return string
     */
    public static function add_menu_logo($item, $args)
    {
        $items = [];

        if (get_option(Settings::MENU_LOGO)) {
            $items[] = '<li class="menuLogo">' .
                        '<a href="' . home_url() . '">' .
                        '<img src="' . wp_get_attachment_url(get_option(Settings::MENU_LOGO)) . '">' .
                        (!is_front_page() ? '<span><i class="fas fa-home"></i></span>' : '') .
                        '</a></li>';
        }

        return implode('', $items) . $item;
    }

    /**
     * TEXTDOMAIN FOR LOCALIZATION
     */
    public static function lanmer_load_textdomain()
    {
        load_plugin_textdomain('lanmer-main', false, basename(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'languages');
    }

    public static function lanmer_zabiegi_pre_get($query)
    {
        if ((is_post_type_archive('zabiegi') && !is_admin() && $query->is_main_query()) || is_tax()) {
            $query->set('posts_per_page', -1);
        }
    }

    /**
     * Zwraca nazwę strony
     */
    public static function lanmer_get_page_name()
    {
        switch (get_post_type()) {
            case 'page':
                return get_the_title();
            case 'zabiegi':
                if (is_tax()) {
                    return get_queried_object()->name;
                } else if (is_archive()) {
                    return 'Oferta';
                } else {
                    return get_the_title();
                }
            case 'pracownicy':
                if (is_archive()) {
                    return 'Ekspertki';
                } else {
                    return get_the_title();
                }
            default:
                return get_post_type();
        }

    }

    /**
     * Zwraca nazwę strony
     */
    public static function lanmer_get_page_name_breadcrumb($id)
    {
        global $wp;
        $result = [
            'url' => get_permalink($id)
        ];
        switch (get_post_type()) {
            case 'page':
                $result['title'] = get_the_title($id);
                break;
            case 'zabiegi':
                $result['title'] = ucfirst(get_the_title($id));
                break;
            default:
                $result['title'] = ucfirst(get_post_type($id));
                break;
        }
        return $result;
    }

    /**
     * Zwraca breadcrumbs-y
     */
    public static function lanmer_get_breadcrumbs($id, &$trail = [])
    {


        if (is_archive() == false) {
            $item = self::lanmer_get_page_name_breadcrumb($id);
            array_unshift($trail, '<a href="' . $item['url'] . '">' . $item['title'] . '</a>');
        }


        switch (get_post_type()) {

            case 'zabiegi':

                $trail = [];

                // link do strony 'oferta'
                $pageUrl = get_page_by_title('oferta', ARRAY_A, 'page');
                array_push($trail, '<a href="' . get_page_link($pageUrl['ID']) . '">Oferta</a>');

                /**
                 * Jedna kategoria z oferty
                 */

                if (is_tax()) {

                    $tax = get_queried_object();
                    array_push($trail, '<a href="' . get_category_link($tax->term_taxonomy_id) . '">' . $tax->name . '</a>');

                } else {

                    /**
                     * Strona oferty
                     */

                    // kategoria
                    $zabiegiCategory = get_the_terms(get_the_ID(), 'kategoria');
                    array_push($trail, '<a href="' . get_category_link($zabiegiCategory[0]->term_id) . '">' . $zabiegiCategory[0]->name . '</a>');

                    // bieżąca strona
                    array_push($trail, '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>');
                }

                break;

            case 'pracownicy':
                array_unshift($trail, '<a href="' . get_post_type_archive_link('pracownicy') . '">Ekspertki</a>');
                break;
        }
        
        // na początku dodaj link do strony głównej
        array_unshift($trail, '<a href="' . home_url() . '"><i class="fas fa-home"></i></a>');

        return $trail;
    }

    // logo shortcode
    public static function logo_shortcode()
    {
        return '<div class="logo"></div>';
    }

    // gallery shortcode
    public static function gallery_shortcode($atts)
    {
        $gallery = Gallery::getInstance()->findAll(['id' => $atts['id']]);

        if (!empty($gallery)) {

            return reset($gallery)->renderContent();
        } else {
            return '';
        }
    }

    public static function time_shortcode($time)
    {
        return "<div class='treatment-duration'><i class=\"far fa-clock\"></i> Czas trwania: " . $time[0] . " min</div>";
    }

    public static function get_dummy_img()
    {
        return plugins_url() . '/lanmer_main/assets/imgs/temporary.jpg';
    }
}