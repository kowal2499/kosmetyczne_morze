<?php
    $id = get_the_ID();
    $image = wp_get_attachment_url(get_post_meta($id, 'photo_treatment')[0]) ?: \admin\Functions::get_dummy_img();
    get_post_meta($id, 'photo_treatment')[0];
    $path = wp_get_attachment_image_src($image, 'thumbnail')[0];

    $name = get_the_title();
    $content = get_the_excerpt();
    $postLink = get_permalink();


    $childrenIds = \cpt\Treatments::getInstance()->findAll([
        'post_parent' => $id
    ]);

    $children = [];
    foreach ($childrenIds as $id) {
        $children[$id] = [
            'name' => get_the_title($id),
            'link' => get_post_permalink($id),
            'img' => wp_get_attachment_url(get_post_meta($id, 'photo_treatment')[0]) ?: \admin\Functions::get_dummy_img()
        ];
    }
?>


    <div class="archive-treatments">
        <?php if ($image): ?>
        <img class="img-circle img-responsive" src="<?php echo $path; ?>" alt="">
        <?php endif; ?>
        <div class="info-block">
            <div class="row">

                <div class="col-md-12">

                    <h3><?php echo $name; ?></h3>


                    <div class="description">
                        <?php echo $content; ?>

                        <div class="actions">
                            <a href="<?php echo $postLink; ?>" class="cta">Więcej informacji</a>
                        </div>

                        <?php edit_post_link(__('Edit This'), '<p class="pull-right">', '</p>'); ?>

                    </div>

                    <?php if (!empty($children)): ?>
                    <div class="sub-treatments <?php if (count($children) > 3) { echo 'slider'; }?>">
                        <?php foreach($children as $id => $data): ?>
                            <div class="tile-wrapper">
                                <div class="tile">

                                    <a href="<?php echo $data['link']; ?>" tabindex="-1">
                                        <div class="image-box">
                                            <img src="<?php echo $data['img']; ?>" alt="">
                                            <div class="image-box-content">
                                                <h3><?php echo $data['name']; ?></h3>
                                            </div>
                                        </div>
                                    </a>

                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
