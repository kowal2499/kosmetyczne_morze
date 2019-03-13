<?php

use admin\Settings;

$settings = Settings::getInstance();
$treatments = \cpt\Treatments::getInstance();
$slider = $settings->getSlider();

$menuItems = $treatments->getHTMLList();

$categories = $treatments->getCategories();


?>


<div class="hero">
    
    <div class="row">

        <div class="menuContainer">
            <div class="sectionLogo">
                <div class="item left">

                    <?php foreach ([
                                       [
                                           'icon' => get_option(Settings::FOOTER_CONTACT_DETAILS)[0]['contact_icon'],
                                           'text' => get_option(Settings::FOOTER_CONTACT_DETAILS)[0]['contact_text']
                                       ],
                                       [
                                           'icon' => get_option(Settings::FOOTER_CONTACT_DETAILS)[1]['contact_icon'],
                                           'text' => get_option(Settings::FOOTER_CONTACT_DETAILS)[1]['contact_text']
                                       ],
                                   ] as $item) : ?>

                        <div style="margin-bottom: 6px;">
                            <div class="block">
                                <div class="ext-box contact-icon">
                                    <div class="int-box">
                                        <i class="<?php echo $item['icon']; ?> fa-1x"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="block">
                                <div class="ext-box contact-txt">
                                    <div class="int-box">
                                        <?php echo $item['text']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="item center">
                    <img src="<?php echo wp_get_attachment_url(get_option(Settings::MAIN_LOGO)); ?>" class="img-responsive">
                </div>

                <div class="item right">
                    <?php if (get_option(Settings::GENERAL_FB)): ?>
                        <a href="<?php echo get_option(Settings::GENERAL_FB); ?>" target="_blank"><img src="<?php echo plugins_url() . '/lanmer_main/assets/imgs/facebook.png' ?>"></a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="sectionMenu">
                <nav data-spy="affix" data-offset-top="300" <?php
                if (is_admin_bar_showing()) {
                    echo ' style="top: 32px;"';
                }
                ?>>
                    <?php wp_nav_menu( array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'container_class' => 'menuBar homePageMenu',
                    ) ); ?>
                </nav>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="heroContainer">
            
            <!-- Slider -->
            <div class="wrapper">
            <div class="slider" id="slider">

            <?php 
            $c = 0;
            
            foreach ($slider as $slide): ?>
                
                <div class="slide" data-id="<?php echo $c; ?>" style="background-image: url('<?php echo wp_get_attachment_url($slide['actor']); ?>')">

                    <?php if ($slide['text']): ?>
                    <div class="sentence">
                        <h3 class="slide-lead"><?php echo $slide['text']; ?></h3>
                        <?php if ($slide['cta_enable']): ?>
                            <a href="<?php echo $slide['cta_link']; ?>" class="cta"><?php echo $slide['cta_text']; ?></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
<!--                    <img class="slide-img" src="--><?php //echo wp_get_attachment_url($slide['actor']); ?><!--">-->
                </div>
                    
                <?php $c+=1; ?>
                
            <?php endforeach; ?>

            </div>
            </div>

            <div class="slide-navigation" id="slide-navigation"></div>

                <nav data-level="0">
                    <div class="ext-box">
                        <div class="int-box">
                            <ul>
                                <?php
                                    foreach ($categories as $category) {
                                        echo '<li>';
                                        echo '<a href="' . get_category_link($category->term_taxonomy_id) .'">';
                                        echo($category->name);
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>


        </div>
    </div>

</div>
