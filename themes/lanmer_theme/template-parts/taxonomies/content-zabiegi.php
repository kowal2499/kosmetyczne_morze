
<?php


if (!$my_post_id) {
    $id = get_the_ID();
} else {
    $id = $my_post_id;
}

$image = wp_get_attachment_url(get_post_meta($id, 'photo_treatment')[0]) ?: \admin\Functions::get_dummy_img();

$path = get_the_permalink($id);

$name = get_the_title($id);
$content = get_the_excerpt($id);
$postLink = get_permalink($id);

$raw_price = get_post_meta($id, 'price_list');
$price = 0;
if ($raw_price && $raw_price[0] && $raw_price[0][0]) {
    $price = $raw_price[0][0]['value'];
}

?>

<div class="treatment-item">

    <div class="row">
        <div class="col-md-10">

            <div class="media">

                <div class="media-left pull-left">
                    <a href="<?php echo $path; ?>"><img class="media-object" src="<?php echo $image; ?>" alt=""></a>
                </div>

                <div class="media-body">

                    <a href="<?php echo $path; ?>">
                        <h4 class="media-heading"><?php echo $name; ?></h4>
                    </a>
                    <p><?php echo $content; ?></p>


                </div>
            </div>

        </div>

        <div class="col-md-2">
            <div class="price">
                <div class="ext-box">
                    <div class="int-box text-center">
                        <?php echo $price . ' zł'; ?>
                        <?php edit_post_link(__('Edit This'), '<p class="pull-right">', '</p>'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>



