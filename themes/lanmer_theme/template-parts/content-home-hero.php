<?php

use admin\Settings;

$settings = Settings::getInstance();
$treatments = \cpt\Treatments::getInstance();
$slider = $settings->getSlider();

$menuItems = $treatments->getHTMLList();

$categories = get_categories([
    'taxonomy' => $treatments->taxonomy,
    'orderby' => 'name',
    'order'   => 'ASC'
]);

?>


<div class="hero">
    
    <div class="row">

        <div class="menuContainer">
            <div class="sectionLogo">
                <img src="<?php echo wp_get_attachment_url(get_option(Settings::MAIN_LOGO)); ?>" class="img-responsive center-block">
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
                
                <div class="slide" data-id="<?php echo $c; ?>">
                    <div class="sentence">
                        <h3 class="slide-lead"><?php echo $slide['text']; ?></h3>
                        <a class="cta"><?php echo $slide['cta_text']; ?></a>
                    </div>
                    
                    <img class="slide-img <?php if ($c==0) { echo 'anim-right'; } ?>" style="" src="<?php echo wp_get_attachment_url($slide['actor']); ?>">
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
