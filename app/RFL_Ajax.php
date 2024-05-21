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
        $userLoggedIn = $userId;

        $displayName = $data['gc_first_name'] ?? '';
        $displayName .= !empty($data['gc_last_name']) ? ' ' . $data['gc_last_name'] : '';

        if (!$userId && $email) {
            $user = get_user_by('email', $email);

            if (empty($user)) {
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

        $stripeKey = get_option('raffle_stripe_secret_key');

        if (!$stripeKey) {
            wp_send_json_error('There is no a stripe api key.');
            return;
        }

        $stripe = new \Stripe\StripeClient($stripeKey);

        /* Get a customer */
        $customerId = 'cus_Q8pxFGvqOK6pvJ';
        $customer = $stripe->customers->retrieve($customerId);

        if (empty($customer)) {
            /* Create a customer */
            $customer = $stripe->customers->create([
                'email' => $email,
                'name'  => $displayName
            ]);
        }

        $user = get_user_by('ID', $userId);

        if (!empty($user)) {
            update_user_meta($userId, 'stripe_customer_id', $customer->id);

            /* Save payment method */
            $setupIntent = $stripe->paymentIntents->create([
                'amount'                    => $data['gc_amount'] ?? 0,
                'currency'                  => 'usd',
                'automatic_payment_methods' => ['enabled' => true],
                'customer'                  => $customer->id
            ]);

            if (!empty($setupIntent->id)) {
                update_user_meta($userId, 'stripe_payment_intent', $setupIntent->id);
            }
        }

        try {
            $subscription = $stripe->subscriptions->create([
                'customer'         => $customer->id,
                'currency'         => 'usd',
                'metadata'         => [
                    'product_id' => 'prod_Q7hA4NMjJ6VdJ0'
                ],
                'items'            => [
                    [
                        'price' => 'price_1PHRmZACbB2tPZl0s6pZ29eH'
                    ]
                ],
                // this subscription is not paid yet
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => ['save_default_payment_method' => 'on_subscription'],
                'expand'           => ['latest_invoice.payment_intent']
            ]);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            wp_send_json_error($e->getMessage());
        }

        if (!empty($subscription->id)) {
            RFL_Database::insert_payment_response([
                'email'       => $user->user_email ?? '',
                'mobile'      => $data['gc_mobile'] ?? '',
                'payment_id'  => $subscription->id,
                'customer_id' => $subscription->customer,
                'amount'      => $amount
            ]);
        }

        if (!$userLoggedIn && !empty($user)) {
            RFL_Functions::user_log_in($user);
        }

        if (isset($subscription->latest_invoice->payment_intent->client_secret)) {
            wp_send_json_success([
                'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret
            ]);
        } else {
            wp_send_json_error([
                'message' => 'Payment error'
            ]);
        }
    }
}