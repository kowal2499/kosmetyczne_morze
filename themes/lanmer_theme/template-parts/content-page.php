<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lanmer_theme
 */
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

                <?php if ($content): ?>
                    <div class="bck" style="background: url()">
                        <div class="content">
                            <h1><?php echo get_the_title(); ?></h1>
                            <?php echo $content; ?>
                            <?php edit_post_link(__('Edit This'), '<p class="pull-right">', '</p>'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
