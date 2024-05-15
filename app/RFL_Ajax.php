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
        $amount = $data['gc_amount'] ?? 0;

        if (!$amount) {
            wp_send_json_error('Empty amount.');
            return;
        }

        $email = $data['gc_email'] ?? '';
        $userId = get_current_user_id() ?: '';

        if (!$userId && $email) {
            $user = get_user_by('email', $email);

            if (empty($user)) {
                $displayName = $data['gc_first_name'] ?? '';
                $displayName .= !empty($data['gc_last_name']) ? ' ' . $data['gc_last_name'] : '';

                $userArgs = [
                    'user_login'   => $email,
                    'first_name'   => $data['gc_first_name'] ?? '',
                    'last_name'    => $data['gc_last_name'] ?? '',
                    'display_name' => $displayName,
                    'user_email'   => $email
                ];

                $userId = wp_insert_user($userArgs);

                if (!is_wp_error($userId)) {
                    $userId = '';
                }
            } else {
                $userId = $user->ID;
            }
        }

        $stripeToken = $data['gc_stripe_token'] ?? '';

        if (!$stripeToken) {
            wp_send_json_error('There is no a stripe token.');
            return;
        }

        $stripe = new \Stripe\StripeClient('');

        try {
            $paymentResponse = $stripe->paymentIntents->create([
                'amount'              => $amount,
                'currency'            => 'usd',
                'description'         => "Purchase for Promotion - 3 entries",
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
                    'user_email'      => $email,
                    'user_id'         => $userId,
                    'active_for_days' => 20,
                ],
            ]);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            wp_send_json_error($e->getMessage());
        }

        $user = get_user_by('ID', $userId);

        if (!empty($paymentResponse->id)) {
            RFL_Database::insert_payment_response([
                'email'           => $user->user_email,
                'mobile'          => $data['gc_mobile'] ?? '',
                'payment_id'      => $paymentResponse->id,
                'amount'          => $amount,
                'payment_request' => serialize($paymentResponse),
            ]);
        }

        RFL_Functions::user_log_in($user);

        wp_send_json_success('Successful payment');
    }
}