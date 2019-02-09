<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lanmer_theme
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="archive" class="site-main">
            <div class="row">
                <div class="pageBody">

                    <?php if ( have_posts() ) : ?>

                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/content', get_post_type() );


                            switch (get_post_type()) {
                                case 'zabiegi':
                                    get_template_part('template-parts/after-content', get_post_type());
                                    break;
                            }


                        endwhile;

                        ?>

                        <div class="breadcrumb">
                            <?php echo implode(' &gt; ', \admin\Functions::lanmer_get_breadcrumbs(get_the_ID())); ?>
                        </div>

                        <?php

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif;
                    ?>

                </div> <!-- .pageBody -->
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();