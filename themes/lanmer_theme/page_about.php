<?php
/*

Template name: Duży obrazek z boku

*/

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

        <div class="row">
            <div class="pageBody about">


		<?php while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page_big_img' );
		endwhile; ?>



                <div class="logo"></div>
                <div class="breadcrumb">
                    <?php echo implode(' &gt; ', \admin\Functions::lanmer_get_breadcrumbs(get_the_ID())); ?>
                </div>
            </div> <!-- .pageBody -->
        </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
