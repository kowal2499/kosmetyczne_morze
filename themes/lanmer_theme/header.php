<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lanmer_theme
 */

use admin\Settings;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >

<!--    <div class="courtain">-->
<!--        <div class="logo"></div>-->
<!--    </div>-->


    <div id="side">
        <div class="side-menu">
            <?php get_template_part('template-parts/menu', 'mobile'); ?>
        </div>
    </div>

    <div class="mobile-side-menu-toggler">
        <a id="toggle" class="cta">Menu</a>
        <?php
            if (get_option(Settings::MENU_LOGO)) {
                echo '<a href="' . home_url() . '" class="togglerLogo"><img src="' . wp_get_attachment_url(get_option(Settings::MENU_LOGO)) . '"></a>';
            }
        ?>
    </div>

    <div id="page" class="site" style="background: url('<?php echo wp_get_attachment_url(get_option(Settings::GENERAL_BACKGROUND)); ?>');">

    <div class="container">

        <?php if ( !is_front_page() ) : ?>

        <header id="masthead" class="row site-header">

            <div class="menuContainer">

                <div class="sectionMenu">
                    <nav data-spy="affix" data-offset-top="50"
                            <?php
                                if (is_admin_bar_showing()) {
                                    echo ' style="top: 32px;"';
                                }
                            ?>>
                        <?php wp_nav_menu( array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                            'container_class' => 'menuBar',
                        ) ); ?>
                    </nav>

                    <div class="pageTitle">
                        <div class="ext-box">
                            <div class="int-box sideLeft">
                                <a href="<?php echo home_url(); ?>">
                                    <img src="<?php echo wp_get_attachment_url(get_option(Settings::MAIN_LOGO)); ?>" class="img-responsive">
                                </a>
                            </div>

                            <div class="int-box sideRight">
                                <h1><?php echo \admin\Functions::lanmer_get_page_name(); ?></h1>
                            </div>

                        </div>

                        <div class="breadcrumb">
                            <?php echo implode(' &gt; ', \admin\Functions::lanmer_get_breadcrumbs(get_the_ID())); ?>
                        </div>

                    </div>

                </div>
            </div>

        </header><!-- #masthead -->


        <?php endif; ?>
    </div><!-- .container -->

    <div class="container">

    <div id="content" class="site-content">
