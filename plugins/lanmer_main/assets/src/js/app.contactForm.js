
kosmetyczneMorze.contactForm = (function($) {

    var $wrapper;
    var $elmEmail, $elmPhone, $elmBody, $elmMessage;

    var init = function(wrapper) {
        $wrapper = $(wrapper);

        $elmEmail = $wrapper.find('.js-email');
        $elmPhone = $wrapper.find('.js-phone');
        $elmBody = $wrapper.find('.js-body');
        $elmButton = $wrapper.find('.js-submit');
        $elmNonce = $wrapper.find('#_wpnonce');
        $elmMessage = $wrapper.find('.js-message');

        $elmMessage.html('');

        $wrapper.find('button[name="form_submit"]').on('click', function(e) {
            e.preventDefault();

            var msg = validate([$elmBody, $elmEmail]);

            if (msg.length === 0) {

                var data = {
                    email: $elmEmail.val(),
                    phone: $elmPhone.val(),
                    body: $elmBody.val(),
                    nonce: $elmNonce.val(),
                    action: 'submit_message_form'
                };

                $.post(_settings.url, data, function(response) {
                    if (response.success) {
                        setTimeout(function () {
                            showMessage('Dziękuję. Wiadomość została wysłana.', 'alert-success');
                            clear();
                        }, 1000);
                    } else {
                        showMessage('Błąd. Wiadomość nie została wysłana.', 'alert-danger');
                    }
                    $elmButton.prop('disabled', false);
                })

                showMessage('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i> Trwa wysyłanie wiadomości ...', 'alert-info');
                $elmButton.prop('disabled', true);

            } else {
                // wypisz braki
                showMessage(msg.join(' '), 'alert-danger');
            }
        });
    };

    var validate = function(items) {
        $elmMessage.html('');
        var returnMessages = [];
        items.forEach(function($item) {
            if ($item.val().length == false) {
                returnMessages.push($item.data('message'));
            }
        })
        return returnMessages;
    };

    var showMessage = function(message, type) {
        $elmMessage.hide();
        $elmMessage.html('<div class="alert ' + type + '" role="alert">' + message + '</div>');
        $elmMessage.fadeIn();
    }

    var clear = function() {
        $elmEmail.val('');
        $elmPhone.val('');
        $elmBody.val('');
    }

    return init;

})(jQuery);
