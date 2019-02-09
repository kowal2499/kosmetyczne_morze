<?php
    use admin\Settings;
?>
<div class="navigation">
    <div class="logo-mobile">
        <a href="<?php echo home_url(); ?>">
            <img src="<?php echo wp_get_attachment_url(get_option(Settings::MAIN_LOGO)); ?>" class="img-responsive">
        </a>
    </div>

    <div class="menu">
        <?php
        wp_nav_menu([
            'theme_location' => 'menu-1',
            'menu_id'        => 'primary-menu',
            'container_class' => '',
        ]);
        ?>
    </div>
</div>

<div class="contact">
    <div class="swirl"></div>
    <?php get_template_part('template-parts/footer', 'contact-details'); ?>
</div>

<?php

