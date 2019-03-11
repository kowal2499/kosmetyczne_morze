<?php
namespace admin;

// include_once(plugin_dir_path(__FILE__) . 'InputsManager.php');

class Settings
{

    const MAIN_LOGO = 'general_main_logo';
    const MENU_LOGO = 'general_menu_logo';
    const MENU_ITEMS_HIDE = 'general_menu_hide';
    const GENERAL_BACKGROUND = 'general_main_background';
    const GENERAL_OWNER_PHOTO = 'owner_logo';
    const RULES = 'rules';

    const FOOTER_BACKGROUND = 'footer_background';
    const FOOTER_BACKGROUND_BLEND = 'footer_background_blend';
    const FOOTER_CONTACT_FORM_SHOW = 'footer_contact_form';
    const FOOTER_CONTACT_FORM_EMAIL = 'footer_destinated_email';
    const FOOTER_CONTACT_DETAILS = 'footer_contacts';
    const CATEGORIES_ORDER = 'categories_order';

    /*
     * Instancja
     */
    private static $instance;

    /*
     * Identyfikator globalnego slidera
     */
    const SLIDER = 'slider';

    private function __construct()
    {
        
        // tryb administracyjny
        if (is_admin()) {

            // własna strona z ustawieniami
            $this->tabs = [
                [
                    'title' => 'Ogólne',
                    'url' => 'general',
                    'manager' => new InputManager(plugin_dir_path(__DIR__) . '..' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'inputs_settings_general.json')
                ],
                [
                    'title' => 'Pokaz slajdów',
                    'url' => 'slideshow',
                    'manager' => new InputManager(plugin_dir_path(__DIR__) . '..' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'inputs_settings_slideshow.json')
                ],
                [
                    'title' => 'Stopka',
                    'url' => 'footer',
                    'manager' => new InputManager(plugin_dir_path(__DIR__) . '..' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'inputs_settings_footer.json')
                ],
                [
                    'title' => 'Regulamin',
                    'url' => 'rules',
                    'manager' => new InputManager(plugin_dir_path(__DIR__) . '..' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'inputs_settings_rules.json')
                ]
            ];

            add_action('admin_menu', function () {
                add_menu_page('Ustawienia', 'Inne treści', 'manage_options', 'ustawienia', array($this, 'pageContent'));
            });

            // rejestracja łańcuchów dla polylang
            foreach ($this->tabs as $tab) {
                //$tab['manager']->polylangRegister();
            }
        }
    }

    public static function getSlider()
    {
        return get_option(self::SLIDER);
    }

    public function pageContent()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('Nie posiadasz wystarczających uprawnień.'));
        }

        // save
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'save') {
            foreach ($_REQUEST['options'] as $key => $value) {
                update_option($key, $value);
            }
            ?>
            <div class="notice updated">
                <p>Zmiany zostały zapisane.</p>
            </div>
            <?php
        }
        
            ?>
            
        <div class="admin-options-wrapper">
            <form class="wrap" method="post">
                <h2>Podstawowe dane prezentowane na stronie</h2>

                    <?php
                        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : reset($this->tabs)['url'];
                    ?>
                    <h2 class="nav-tab-wrapper">

                        <?php foreach ($this->tabs as $tab): ?> 
                            <a href="?page=ustawienia&tab=<?php echo $tab['url']; ?>"
                            class="nav-tab <?php echo $active_tab == $tab['url'] ? 'nav-tab-active' : ''; ?>">
                            <?php echo $tab['title']; ?>
                            </a>
                        <?php endforeach; ?>

                    </h2>

                    <?php
                    // generate inputs
                    foreach ($this->tabs as $tab) {
                        if ($tab['url'] === $active_tab) {
                            $tabManager = $tab['manager'];

                            foreach ($tabManager->getFieldsAsObjects() as $input) {
                                $input->render();
                            }

                        } else {
                            continue;
                        }
                    }
                    ?>
                    <br>
                    <input type="hidden" name="action" value="save">
                    <input type="submit" class="button button-primary" value="Zapisz zmiany">
                </form>

            </div>
<?php
    }

    public function getOption2(string $id)
    {
        foreach((array) $this->tabs as $tab) {
            if (in_array($id, $tab['manager']->getIds())) {
                $input = $tab['manager']->getInput($id);
                if ($input) {
                    return pll__($input->getValue());
                }
            }
        }

        return null;
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Settings();
        }
        return self::$instance;
    }
}