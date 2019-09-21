<?php

namespace cpt;

abstract class CustomPost
{
    protected $name;
    protected $names;
    protected $args;
    protected $metaboxes;
    
    protected function __construct()
    {
        $this->register();

        if (isset($this->metaboxes) && !empty($this->metaboxes)) {
            foreach ($this->metaboxes as $metabox) {
                if (isset($metabox['name']) && isset($metabox['manager'])) {
                    $this->addMetaBox(
                        $metabox['name'],
                        $metabox['manager']
                    );
                }
            }
        }
        $this->hookSave();

    }

    protected function register()
    {
        if (!post_type_exists($this->name)) {
            add_action('init', function () {
                $args = array_merge(
                    ['labels' => $this->names],
                    $this->args
                );
                register_post_type($this->name, $args);
            });
        }        
    }

    
    private function addMetaBox($title, $fieldsManager, $context = 'normal', $priority = 'default')
    {
        add_action('add_meta_boxes', function () use ($title, $fieldsManager, $context, $priority) {
            $id = strtolower(str_replace(' ', '_', $title));
            add_meta_box(
                $id,
                ucwords($title),
                function () use ($fieldsManager, $id) {
                    global $post;
                    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'">';

                    echo $this->beforeMetaBox();

                    foreach ($fieldsManager->getFieldsAsObjects() as $input) {

                        // TODO: przenieść poniższe do klasy managera

                        // odczytaj wartość pola z bazy wordpressa
                        $value = get_post_meta($post->ID, $input->getWpId(), true);
                        $input->setValue($value);
                        // narysuj pole
                        $input->render();
                    }
                },
                $this->name, // post type name
                $context,
                $priority
            );
        });
    }

    private function hookSave()
    {
        global $post_id;

        add_action('save_post_' . $this->name, function () use ($post_id) {
           
            global $post;

            // verify nonce
            if (isset($_POST['custom_meta_box_nonce']) && !wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) {
                if ($post) {
                    return $post->ID;
                } else {
                    return null;
                }
            }

            
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post->ID;
            }

            foreach ($this->metaboxes as $metabox) {
                
                foreach ($metabox['manager']->getFields() as $id => $field) {
                    
                    $ret = update_post_meta(
                        $post->ID,
                        $id,
                        $_POST[$metabox['manager']->getVarWrapper()][$id]
                    );
                }
            }

        });

    }

    protected function beforeMetaBox()
    {
        return '';
    }

    /*
     * poniższe funkcje do sprawdzenia i ew. odstrzału
     */
    public function getAll(): array
    {
        $items = array();

        $loop = new WP_Query(array('post_type' => $this->name, 'posts_per_page' => -1));
        while ($loop->have_posts()) :
            $loop->the_post();
            $item = [];
            $item["general"] = get_post(null, ARRAY_A);
            $item["meta"] = get_post_meta(get_the_ID());
            $items[] = $item;
        endwhile;
        wp_reset_query();
        return $items;
    }
}
