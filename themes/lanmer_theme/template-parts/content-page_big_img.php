<?php

use admin\Settings;
ob_start();
the_content();
$content = ob_get_clean();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

	</header><!-- .entry-header -->

	<div class="page-content">
        <div class="row">
            <div class="col-md-12">

                <div class="about-page-wrapper" style="background: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>')">

                    <div class="ext-box">
                        <div class="int-box">

                            <img src="<?php echo wp_get_attachment_url(get_option(Settings::GENERAL_OWNER_PHOTO)); ?>" alt="" class="about-thumbnail img-circle">

                            <div class="content alabaster">
                                <?php echo $content; ?>
                                <?php edit_post_link(__('Edit This'), '<p class="pull-right">', '</p>'); ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
