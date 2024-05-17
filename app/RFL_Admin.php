<?php


class RFL_Admin
{
    static function init()
    {
        add_action('add_meta_boxes', [self::class, 'register_meta_boxes']);
        add_action('save_post', [self::class, 'save_post_call'], 10, 3);
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
}