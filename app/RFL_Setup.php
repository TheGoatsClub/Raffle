<?php


class RFL_Setup
{
    static function init()
    {
        add_action('init', [self::class, 'init_call']);
        add_action('admin_enqueue_scripts', [self::class, 'admin_scripts_call']);
        add_action('wp_enqueue_scripts', [self::class, 'wp_enqueue_scripts_call']);
        add_filter('template_include', [self::class, 'page_template']);
    }

    static function admin_scripts_call()
    {
        $post = get_post();
        if (!empty($post) && $post->post_type === 'promotion') {
            wp_enqueue_style('raffle-admin-styles', RFL_PLUGIN_URL . 'dest/css/admin.css');
            wp_enqueue_script('raffle-admin-scripts', RFL_PLUGIN_URL . 'dest/js/admin-scripts.js');
        }
    }

    static function wp_enqueue_scripts_call()
    {
        wp_enqueue_style('raffle-admin-styles', RFL_PLUGIN_URL . 'dest/css/front-end.css');

        wp_enqueue_script('raffle-stripe', 'https://js.stripe.com/v3/');
        wp_enqueue_script('raffle-front-end-scripts', RFL_PLUGIN_URL . 'dest/js/front-end-scripts.js', ['jquery'], time());

        wp_localize_script('raffle-front-end-scripts', 'raffle', [
            'ajaxurl'   => admin_url('admin-ajax.php'),
            'nonce'     => wp_create_nonce('payment-promotion-nonce'),
            'stripeKey' => get_option('raffle_stripe_publishable_key')
        ]);
    }

    static function init_call()
    {
        RFL_Functions::create_post_type('promotion', [
            'menu_icon' => 'dashicons-format-image',
            'show_in_rest' => true,
            'labels'       => [
                'name'          => __('Promotions', RAFFLE_DOMAIN),
                'singular_name' => __('Promotions', RAFFLE_DOMAIN),
                'add_new_item'  => __('Add New Promotion', RAFFLE_DOMAIN),
                'view_item'     => __('View Promotion', RAFFLE_DOMAIN),
                'search_items'  => __('Search Promotion', RAFFLE_DOMAIN),
                'not_found'     => __('No Promotions found', RAFFLE_DOMAIN),
                'menu_name'     => __('Promotions', RAFFLE_DOMAIN)
            ],
        ]);
    }

    static function page_template($page_template)
    {
        if (is_singular('promotion')) {
            return RFL_Helper::get_path('templates/single-promotion');
        }

        return $page_template;
    }
}