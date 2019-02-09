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
		<main id="main" class="site-main">

        <?php if ( !is_front_page() && !is_archive() ) : ?>
        <div class="row">
            <div class="pageBody">

        <?php endif; ?>



		<?php while ( have_posts() ) :
			the_post();

		    if (is_front_page()) {
                get_template_part( 'template-parts/content-front_page', 'page' );
            } else {
                get_template_part('template-parts/content', 'page');
            }
		endwhile; ?>



        <?php if ( !is_front_page() && !is_archive()) : ?>
                <div class="logo"></div>
                <div class="breadcrumb">
                    <?php echo implode(' &gt; ', \admin\Functions::lanmer_get_breadcrumbs(get_the_ID())); ?>
                </div>
            </div> <!-- .pageBody -->
        </div>
        <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
