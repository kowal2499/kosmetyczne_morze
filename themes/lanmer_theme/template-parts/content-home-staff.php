<?php
$settings = \admin\Settings::getInstance();
$staff = \cpt\Staff::getInstance()->findAll();

$names = array_map(function ($item) { return $item['title']; }, $staff)
?>

<div class="staff">
    <div class="row">
<!--        <div class="col-md-3">-->
<!--            <h2>Ekspertki</h2>-->
<!---->
<!--            <img src="--><?php //echo plugins_url(). '/lanmer_main/assets/imgs/logo-dark-tiny.png'; ?><!--" alt="Morze SPA małe logo" class='small-logo'>-->
<!---->
<!--            <div id="navigation"></div>-->
<!--        </div>-->
        <div class="col-md-offset-2 col-md-8">
            <div class="slider" id="slider" data-names="<?php echo htmlspecialchars(json_encode($names)); ?>">

                <?php
                foreach ($staff as $employee) {
                    echo '<div class="slide" data-title="' . $employee['title'] . '">';
                    echo '<div class="background">';
                    echo '<h3>' . '<img class="mobile-pic" src="' . wp_get_attachment_image_src($employee['photo'], 'full')[0] . '" alt="">' . $employee['title'] . '</h3>';
                    echo '<p>';
                    echo $employee['content'];
                    echo '</p>';

                    echo '<div class="footer">';
                    echo '<ul>';

                    foreach ($employee['contacts'] as $contact) {
                        $action = '';
                        switch ($contact['contactType']) {
                            case 'far fa-envelope':
                                $action = 'mailto:' . $contact['contactValue'];
                                break;

                            case 'fas fa-phone-volume':
                                $action = 'tel:' . $contact['contactValue'];
                                break;
                        }
                        echo '<li><a href="' . $action. '"><i class="cta ' . $contact['contactType'] . '"></i>'. $contact['contactValue'] .'</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';


                    echo '</div>';
                    echo '<img src="' . wp_get_attachment_image_src($employee['photo'], 'full')[0] . '" alt="">';
                    echo '</div>';
                }
                ?>

            </div>
        </div>
    </div>

</div>