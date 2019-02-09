<?php

use admin\Settings;

$settings = Settings::getInstance();
$treatments = \cpt\Treatments::getInstance();
$slider = $settings->getSlider();

$menuItems = $treatments->getHTMLList();

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

            <!-- Menu in hero section, level zero -->
            <?php if (isset($treatments->getLevelsMap()[0]) && !empty($treatments->getLevelsMap()[0])): ?>
                <nav data-level="0">
                    <div class="ext-box">
                        <div class="int-box">
                            <ul>
                                <?php
                                
                                    foreach ($treatments->getLevelsMap()[0] as $parent => $items) {
                                        foreach ($items as $item) {
                                            
                                            $post = $treatments->getAllPosts()[$item]['post'];
                                            $link = $treatments->getAllPosts()[$item]['link'];
                                            echo '<li data-id="' . $post['ID'] . '">';
                                            echo '<a href="' . $link . '">';
                                            echo $post['post_title'];
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </nav>
            <?php endif; ?>

            <?php
                $levels = array_keys($treatments->getLevelsMap());
                unset($levels[0]);
            ?>

            <?php foreach ($levels as $level): ?>
                    
                <?php foreach ($treatments->getLevelsMap()[$level] as $parent => $items): ?>
                    <nav data-level="<?php echo $level; ?>" data-parent="<?php echo $parent; ?>" class="hidden">
                        <div class="ext-box">
                            <div class="int-box">
                                <ul>
                                    <?php
                                        foreach ($items as $item) {
                                            $post = $treatments->getAllPosts()[$item]['post'];
                                            $link = $treatments->getAllPosts()[$item]['link'];
                                            echo '<li data-id="' . $post['ID'] . '">';
                                            echo '<a href="' . $link . '">';
                                            echo $post['post_title'];
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </nav>  
                <?php endforeach; ?>
                        
            <?php endforeach; ?>

        </div>
    </div>

</div>
