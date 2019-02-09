<div class="footer-column">

<h4>Wyślij zapytanie</h4>

    <form action="" class="js-footer-form">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <input type="email" class="form-group js-email" placeholder="Adres email" name="form_email" data-message="Niepoprawny adres email.">
                </div>

                <div class="form-group">
                    <input type="text" class="form-group js-phone" placeholder="Numer telefonu" name="form_phone">
                </div>
            </div>

            <div class="col-md-7">
                <div class="form-group">
                    <textarea cols="30" rows="5" class="form-control js-body" name="form_body" data-message="Uzupełnij treść wiadomości." placeholder="Treść wiadomości"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
                <div class="js-message"></div>
            </div>
            <div class="col-md-2 text-right">
                <?php wp_nonce_field('submit_form'); ?>
                <button type="submit" class="btn btn-default js-submit" name="form_submit" data-url="<?php echo admin_url('admin-ajax.php'); ?>">Wyślij</button>
            </div>
        </div>
    </form>

</div>
