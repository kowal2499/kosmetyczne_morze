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

$tax = get_queried_object();
?>

    <div id="primary" class="content-area">
        <main id="archive" class="site-main">
            <div class="row">
                <div class="pageBody">

                    <div class="row">
                        <div class="col-md-12">

                            <?php if (have_posts()) : ?>

                                <div class="treatment-category">

                                    <div class="treatment-heading">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                            <h2><?php echo $tax->name; ?></h2>
                                            <i class="fa fa-chevron-down pull-right" aria-hidden="true"></i>

                                        </a>
                                    </div>


                                    <div id="collapseOne" class="treatment-body panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

                                        <?php while (have_posts()) : the_post(); ?>

                                           <?php get_template_part( 'template-parts/taxonomies/content', get_post_type() ); ?>

                                        <?php endwhile; ?>

                                    </div>

                                </div>

                            <?php else : ?>

                                <?php get_template_part( 'template-parts/taxonomies/content', 'none' ); ?>

                            <?php endif; ?>

                            <div class="breadcrumb">
                                <?php echo implode(' &gt; ', \admin\Functions::lanmer_get_breadcrumbs(get_the_ID())); ?>
                            </div>
                            <div class="logo"></div>

                        </div>
                    </div>

                </div> <!-- .pageBody -->
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();