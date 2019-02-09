<?php
    $id = get_the_ID();
    $image = get_post_meta($id, 'photo_square')[0];
    $path = wp_get_attachment_image_src($image, 'full')[0];

    $name = get_the_title();
    $content = get_the_content();
    $contacts = get_post_meta($id, 'contacts')[0];
?>

    <div class="staff-contact">
        <img class="img-circle img-responsive" src="<?php echo $path; ?>" alt="">
        <div class="info-block">
            <div class="row">

                <div class="col-md-12">

                    <h3><?php echo $name; ?></h3>

                    <?php if ($contacts): ?>
                        <ul>
                            <?php
                            foreach ($contacts as $contact) {
                                $action = '';
                                switch ($contact['contactType']) {
                                    case 'far fa-envelope':
                                        $action = 'mailto:' . $contact['contactValue'];
                                        break;

                                    case 'fas fa-phone-volume':
                                        $action = 'tel:' . $contact['contactValue'];
                                        break;
                                }
                                echo '<li><a href="' . $action . '"><i class="' . $contact['contactType'] . '"></i>' . $contact['contactValue'] . '</a></li>';
                            }
                            ?>
                        </ul>

                    <?php endif; ?>

                    <div class="description">
                        <?php echo $content; ?>
                    </div>

                    <?php edit_post_link(__('Edit This'), '<p class="pull-right">', '</p>'); ?>

                </div>

            </div>
        </div>
    </div>
