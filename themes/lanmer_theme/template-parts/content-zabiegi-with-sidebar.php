<?php
$background = get_post_meta($id, 'photo_background')[0];
$backgroundPriceList = get_post_meta($id, 'pricelist_background')[0];
$priceList = get_post_meta($id, 'price_list')[0];
ob_start();
the_content();
$content = ob_get_clean();

/**
 *
 * sidebar
 *
 * 1. ustalamy czy zabieg ma dzieci
 * 2. jeśli tak to rysujemy sidebar
 * 3. nad sidebarem nazwa i link do zabiegu macierzystego
 * 4. w sidebarze rodzeństwo
 *
 * content
 * 1. content
 * 2. odnośniki do dzieci
 * 3. nawigacja left/right pomiędzy rodzeństwem
 *
 *
 */

$children = get_children([
    'post_parent' => $id,
    'post_type'   => 'zabiegi',
    'numberposts' => -1,
    'order' => 'ASC',
]);

$siblings = cpt\Treatments::getInstance()->findAll([
    'post_parent' => wp_get_post_parent_id($id)
]);

?>

<div class="single-treatment">

    <div class="row">

        <div class="col-md-3">
            <div class="morze-sidebar">
                <ul>
                    <?php foreach ($siblings as $sibling): ?>
                        <li class="<?php echo $sibling == $id ? 'active' : ''; ?>">

                            <a href="<?php echo get_permalink($sibling); ?>">
                                <?php echo get_the_title($sibling); ?>
                            </a>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="col-md-9">

            <?php get_template_part('template-parts/after-content', get_post_type()); ?>

        </div>
    </div>

</div>