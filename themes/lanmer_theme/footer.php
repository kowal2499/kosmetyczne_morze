<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lanmer_theme
 */
use admin\Settings;
?>

	</div><!-- #content -->
</div><!-- .container -->

<footer id="colophon" class="site-footer" style="background: url('<?php echo wp_get_attachment_url(get_option(Settings::FOOTER_BACKGROUND));?>')">
    <div class="container">

        <div class="footer-content">



            <div class="row">

                <div class="col-sm-12 col-md-4">
                    <?php get_template_part('template-parts/footer', 'contact-details'); ?>
                </div>

                <div class="hidden-sm hidden-xs col-md-2">
                    <?php get_template_part('template-parts/footer', 'menu'); ?>
                </div>

                <?php if (get_option(Settings::FOOTER_CONTACT_FORM_SHOW) === '1'): ?>
                    <div class="col-sm-12 col-md-6">
                        <?php get_template_part('template-parts/footer', 'contact-form'); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="basic-about">
                <div class="row">

                    <div class="col-sm-12">
                        <div class="basic-info">

                            <div class="ext-box">
                                <div class="int-box text-center">
                                    <strong>Morze Możliwości Kosmetyczne Spa</strong><br>Marta Kowalska (dawny Lanmer Day Spa)<br>
                                    &copy; <?php echo date('Y'); ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div><!-- .container -->
</footer><!-- #colophon -->


</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
