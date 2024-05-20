<?php


class RFL_Admin
{
    static function init()
    {
        add_action('add_meta_boxes', [self::class, 'register_meta_boxes']);
        add_action('save_post', [self::class, 'save_post_call'], 10, 3);
        add_action('admin_menu', [self::class, 'admin_menu_call']);
        add_action('admin_init', [self::class, 'admin_init_call']);

        add_filter('plugin_action_links', [self::class, 'add_plugin_link'], 10, 2);
    }

    static function register_meta_boxes()
    {
        add_meta_box(
            'gc-getaways-fields',
            __('Getaways fields', RAFFLE_DOMAIN),
            [self::class, 'metabox_call'],
            'promotion',
            'advanced',
            'high'
        );
    }

    static function admin_menu_call()
    {
        add_menu_page(
            'RaffleClub',
            'RaffleClub',
            'manage_options',
            RAFFLE_SETTING_PAGE,
            [self::class, 'raffle_setting_page'],
            'dashicons-admin-settings',
            20
        );
    }

    static function admin_init_call()
    {
        $settings = [
            'raffle_stripe_publishable_key',
            'raffle_stripe_secret_key'
        ];

        foreach ($settings as $setting) {
            register_setting('raffle-settings-group', $setting);
        }
    }

    static function raffle_setting_page()
    {
        include RFL_Helper::get_path('parts/admin/admin-setting-page');
    }

    static function metabox_call($post)
    {
        include RFL_Helper::get_path('parts/admin/metaboxes');
    }

    static function save_post_call($postId, $post, $update)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $postId)) {
            return;
        }

        if (!$update) {
            return;
        }

        $data = sanitize_post($_POST);

        if (!empty($data)) {
            foreach ($data as $postKey => $postValue) {
                if (strpos($postKey, 'raffle') === false) {
                    continue;
                }

                update_post_meta($postId, $postKey, $postValue);
            }
        }
    }

    static function add_plugin_link($plugin_actions, $plugin_file)
    {
        $new_actions = [];

        if ('goat-club-raffle/goat-club-raffle.php' === $plugin_file) {
            $new_actions['cl_settings'] = sprintf(__(
                '<a href="%s">Settings</a>', RAFFLE_DOMAIN),
                esc_url(admin_url('options-general.php?page='.RAFFLE_SETTING_PAGE))
            );
        }

        return array_merge($new_actions, $plugin_actions);
    }
}