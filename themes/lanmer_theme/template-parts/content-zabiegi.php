<?php
    $background = get_post_meta($id, 'photo_background')[0];
    $backgroundPriceList = get_post_meta($id, 'pricelist_background')[0];
    $priceList = get_post_meta($id, 'price_list')[0];
    ob_start();
    the_content();
    $content = ob_get_clean();

?>

<div class="single-treatment">

    <div class="row">
        <div class="col-md-12">

            <?php if ($content): ?>
            <div class="bck" style="background: url('<?php echo wp_get_attachment_url($background);?>')">
                <div class="content">
                    <h1><?php echo get_the_title(); ?></h1>
                    <?php echo $content; ?>
                    <?php edit_post_link(__('Edit This'), '<p class="pull-right">', '</p>'); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($priceList): ?>
            <div class="bck reversed" style="background: url('<?php echo wp_get_attachment_url($backgroundPriceList);?>')">
                <div class="price-list">
                    <h2>Cennik</h2>
                    <ul>
                    <?php
                        foreach ($priceList as $item) {
                            echo '<li>' . '<span class="name">' . $item['name'] . '</span><span class="separator">-</span><span class="price">' . $item['value'] . ' zł</span>' . '</li>';
                        }
                    ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>

</div>