<?php


class RFL_Setup
{
    static function init()
    {
        add_action('init', [self::class, 'init_call']);
        add_action('admin_enqueue_scripts', [self::class, 'admin_scripts_call']);
    }

    static function admin_scripts_call()
    {
        $post = get_post();
        if (!empty($post) && $post->post_type === 'promotions') {
            wp_enqueue_style('raffle-admin-styles', RFL_PLUGIN_URL . 'dest/css/admin.css');
            wp_enqueue_script('raffle-admin-scripts', RFL_PLUGIN_URL . 'dest/js/admin-scripts.js');
        }
    }

    static function init_call()
    {
        RFL_Functions::create_post_type('promotions', [
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
}