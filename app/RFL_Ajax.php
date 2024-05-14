<?php


class RFL_Ajax
{
    static function init()
    {
        $names = [
            'promotion_sign_up',
        ];

        foreach ($names as $name) {
            add_action("wp_ajax_$name", [self::class, $name]);
            add_action("wp_ajax_nopriv_$name", [self::class, $name]);
        }
    }

    static function promotion_sign_up()
    {
        check_ajax_referer('payment-promotion-nonce', 'nonce');

        if (empty($_POST)) {
            wp_send_json_error('There is no post data.');
            return;
        }

        $data = sanitize_post($_POST);

        $stripeToken = $data['gc_stripe_token'] ?? '';

        if (!$stripeToken) {
            wp_send_json_error('There is no a stripe token.');
            return;
        }

        $stripe = new \Stripe\StripeClient('');

        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount'              => 1,
                'currency'            => 'usd',
                'description'         => '',
                'payment_method_data' => [
                    'type' => 'card',
                    'card' => [
                        'token' => $stripeToken,
                    ],
                ],
                'confirmation_method' => 'manual',
                'confirm'             => true,
                'return_url'          => get_site_url(),
                'metadata'            => [
                    'user_email'      => '',
                    'user_id'         => '',
                    'active_for_days' => 20,
                ],
            ]);

            $paymentIntentId = $paymentIntent->id;

        } catch (\Stripe\Exception\ApiErrorException $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }
}