<?php

$treatments = \cpt\Treatments::getInstance();

$thisPost = get_the_ID();
$parentPosts = get_post_ancestors($thisPost);

if (empty($parentPosts)) {
    // we are on top level post

    $search = [
        'post_parent' => 0,
        'post__not_in' => [$thisPost]
    ];

} else {
    $search = [
        'post_parent' => reset($parentPosts),
        'post__not_in' => [$thisPost]
    ];

}

$siblings = null; /*$treatments->findAll($search);*/
$children = $treatments->findAll(['post_parent' => $thisPost]);

/**
 * VIEW CHILDREN
 */
?>

<div class="after-treatment-siblings">
<?php if ($children): ?>

    <hr>
    <h2><?php echo get_the_title() . ' - całość oferty:'; ?></h2>

    <div class="tile-section">
    <?php foreach ($children as $child): ?>

        <?php
        $title = get_the_title($child);
        $link = get_post_permalink($child);
        $img = get_post_meta($child, 'photo_treatment')[0];
        ?>

        <div class="tile-wrapper">
            <div class="tile">
                <div class="image-box">
                    <img src="<?php echo wp_get_attachment_url($img) ?: \admin\Functions::get_dummy_img(); ?>" alt="">
                    <div class="image-box-content">
                        <h3><?php echo $title; ?></h3>
                        <div class="hidden-info">
                            <a class="cta" href="<?php echo $link; ?>" tabindex="-1">Zobacz</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php endforeach; ?>
    </div>

<?php endif; ?>



<?php
/**
 * VIEW SIBLINGS
 */

if ($siblings):

?>
    <hr>

    <h2>Może cię również zainteresować:</h2>

    <div class="tile-section">
    <?php foreach ($siblings as $sibling): ?>

        <?php
        $title = get_the_title($sibling);
        $link = get_post_permalink($sibling);
        $img = get_post_meta($sibling, 'photo_treatment')[0] ?: \admin\Functions::get_dummy_img();
        ?>



        <div class="tile-wrapper">
            <div class="tile">
                <div class="image-box">
                    <img src="<?php echo wp_get_attachment_url($img) ?: \admin\Functions::get_dummy_img(); ?>" alt="">
                    <div class="image-box-content">
                        <h3><?php echo $title; ?></h3>
                        <div class="hidden-info">
                            <a class="cta" href="<?php echo $link; ?>" tabindex="-1">Zobacz</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
    <hr>
<?php endif; ?>
</div><!-- .after-treatment-siblings -->