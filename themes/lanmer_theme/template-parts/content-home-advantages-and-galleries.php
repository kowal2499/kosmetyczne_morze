<?php
    $settings = \admin\Settings::getInstance();
    $galleries = \cpt\Gallery::getInstance()->findAll([
        'customCategory' => 'strona_glowna_zalety'
    ]);
?>

<div class="about-us">

    <?php
        foreach ($galleries as $gallery) {
            echo $gallery->render();
        }
    ?>
    
</div>