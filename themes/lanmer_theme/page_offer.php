<?php
/*

Template name: Offer

*/

get_header();

$treatments = \cpt\Treatments::getInstance();
$categories = $treatments->getCategories();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

        <div class="row">
            <div class="pageBody offer">

                <?php foreach ($categories as $id => $category): ?>

                    <?php
                        $the_query = new WP_Query([
                            'post_type' => 'zabiegi',
                            'posts_per_page' => -1,
                            'tax_query' => [
                                [
                                    'taxonomy' => 'kategoria',
                                    'field' => 'term_id',
                                    'terms' => $category->term_id,
                                ]
                            ]
                        ]);
                    ?>

                    <div class="treatment-category">

                        <div class="treatment-heading">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $id; ?>" aria-expanded="true" aria-controls="collapseOne">

                                <h2><?php echo $category->name; ?></h2>
                                <i class="fa fa-chevron-down pull-right" aria-hidden="true"></i>

                            </a>
                        </div>

                        <div id="collapseOne<?php echo $id; ?>" class="treatment-body panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

                    <?php if ($the_query->have_posts()) : ?>

                        <!-- the loop -->
                        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

                        <?php
                            set_query_var( 'my_post_id', get_the_ID() );
                        ?>

                                    <?php while (have_posts()) : the_post(); ?>

                                        <?php get_template_part( 'template-parts/taxonomies/content', 'zabiegi' ); ?>

                                    <?php endwhile; ?>


                        <?php endwhile; ?>
                        <!-- end of the loop -->

                        <?php wp_reset_postdata(); ?>

                    <?php else : ?>
                        <p><?php esc_html_e('Brak zabiegów w tej grupie'); ?></p>
                    <?php endif; ?>
                        </div>
                    </div>

                <?php endforeach; ?>


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
