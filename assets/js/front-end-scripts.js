(function($){
    $(document).ready(function() {
        const ajax = raffle.ajaxurl;
        const stripeKey = raffle.stripeKey;
        let stripe = null;
        let card = null;


        if (stripeKey) {
            stripe = Stripe(raffle.stripeKey);
            const elements = stripe.elements();
            const style = {
                base   : {
                    iconColor : '#fff',
                    color     : '#fff',
                    fontWeight: '400',
                    fontFamily: '"Clash Display", "Arial", "Helvetica", sans-serif',
                    fontSize  : '16px',
                    '::placeholder': {
                        color: '#fff'
                    },
                },
                invalid: {
                    color    : '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            card = elements.create('card', {
                style         : style,
                hidePostalCode: true
            });
            let cardSelector = '#gc_credit_card';

            if ($(cardSelector).length) {
                card.mount(cardSelector);
            }
        }


        const paymentForm = $('.gc_popup__form_payment');
        if (paymentForm.length) {
            $(paymentForm).on('submit', function (e) {
                e.preventDefault();

                const formData = new FormData($(this)[0]);

                formData.append('action', 'promotion_sign_up');
                formData.append('nonce', raffle.nonce);

                if (stripeKey && stripe && card) {
                    stripe.createToken(card).then(function(result) {
                        if (result.error) {
                            console.log(result.error.message);
                        } else {
                            formData.append('gc_stripe_token', result.token.id);
                        }
                    });
                }

                signUpFormAjax(formData);
            });
        }

        function signUpFormAjax(formData)
        {
            const wrap = $('.gc_popup');

            jQuery.ajax({
                type       : 'POST',
                url        : ajax,
                data       : formData,
                dataType   : 'json',
                processData: false,
                contentType: false,
                beforeSend : function () {
                    $(wrap).addClass('_spinner');
                },
                success    : function (response) {
                    $(wrap).removeClass('_spinner');

                    if (response) {
                        if (response.message) {
                            console.log(response.message);
                        }
                    }
                },
                error      : function (err) {
                    console.log('error', err);
                }
            });
        }
    });
})(jQuery);