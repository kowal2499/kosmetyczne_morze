
<div class="footer-column">

    <h4>Dane kontaktowe</h4>

    <?php foreach (get_option(\admin\Settings::FOOTER_CONTACT_DETAILS) as $contactDetail): ?>

    <div class="contact-detail-item">
        <div class="contact-detail-icon">
            <div class="ext-box">
                <div class="int-box">
                    <?php if ($contactDetail["contact_icon"]): ?>
                        <i class="<?php echo $contactDetail["contact_icon"] . ' fa-2x'; ?>"></i>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="contact-detail-text">

            <?php if ($contactDetail["contact_link_type"] !== '0'): ?>

                <?php
                    $type = '';
                    switch ($contactDetail['contact_link_type']) {
                        case 'email':
                            $type = 'mailto:'; break;
                        case 'phone':
                            $type = 'tel:'; break;
                        case 'www':
                            $type = '';
                    }
                ?>
                <a href="<?php echo $type . $contactDetail["contact_link_destination"]; ?>"
                   <?php $type === 'www' ? 'target="_blank"' : '' ?>>
            <?php endif; ?>

            <div class="ext-box">
                <div class="int-box">
                    <?php echo $contactDetail["contact_text"]; ?>
                </div>
            </div>

            <?php if ($contactDetail["contact_link_type"] !== '0'): ?>
                </a>
            <?php endif; ?>


        </div>
    </div>

    <?php endforeach; ?>

</div>
