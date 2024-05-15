<?php


class RFL_Functions
{
    static function write_log(array $data = [])
    {
        if (empty($data)) {
            return;
        }

        file_put_contents(
            RFL_PLUGIN_PATH . 'logs.log',
            date('Y-m-d H:i:s') . ' ' . RFL_Helper::get_ip() . ' ' . json_encode($data) . PHP_EOL,
            FILE_APPEND
        );
    }

    static function get_response(): array
    {
        $input = file_get_contents('php://input');

        $inputArray = json_decode($input, true);

        file_put_contents(
            RFL_PLUGIN_PATH . 'response_logs.log',
            date('Y-m-d H:i:s') . ' ' . RFL_Helper::get_ip() . $input . PHP_EOL,
            FILE_APPEND
        );

        return $inputArray ?: [];
    }

    static function create_post_type(string $postType = '', array $args = [])
    {
        $args = array_merge([
            'public'        => true,
            'show_ui'       => true,
            'has_archive'   => true,
            'menu_position' => 20,
            'hierarchical'  => true,
            'supports'      => ['title', 'excerpt', 'thumbnail', 'editor'],
        ], $args);

        register_post_type($postType, $args);
    }

    static function create_taxonomy($taxonomy, $postType, $args = []): void
    {
        $args = array_merge([
            'description'  => '',
            'public'       => true,
            'hierarchical' => true,
            'has_archive'  => true,
        ], $args);

        register_taxonomy($taxonomy, $postType, $args);
    }

        static function user_log_in($user)
    {
        if (empty($user)) {
            return;
        }

        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user->user_login, $user);
    }
}