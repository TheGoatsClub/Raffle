<?php


class RFL_Database
{
    private static string $table_payments = RAFFLE_PREFIX . '_stripe_payments';

    static function table_stripe_payments_install()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table = $wpdb->prefix . self::$table_payments;

        $create_table = "CREATE TABLE IF NOT EXISTS {$table} (
            `id` int NOT NULL AUTO_INCREMENT,
            `email` varchar(250) DEFAULT NULL,
            `mobile` varchar(250) DEFAULT NULL,
            `payment_id` varchar(250) DEFAULT NULL,
            `customer_id` varchar(250) DEFAULT NULL,
            `amount` int(10) unsigned DEFAULT NULL,
            `message` TEXT NULL,
            `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) {$charset_collate} ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($create_table);
    }

    static function insert_payment_response($data = []): bool
    {
        global $wpdb;
        $table = $wpdb->prefix . self::$table_payments;

        $args = array_merge([
            'email'           => '',
            'mobile'          => '',
            'payment_id'      => '',
            'amount'          => '',
            'payment_request' => '',
            'date_created'    => date('Y-m-d H:i:s')
        ], $data);

        return !!$wpdb->insert($table, $args);
    }

    static function drop_table(string $tableWithoutPrefix = '')
    {
        if (!$tableWithoutPrefix) {
            return;
        }

        global $wpdb;
        $table = $wpdb->prefix . $tableWithoutPrefix;

        $query = "DROP TABLE IF EXISTS {$table}";

        $wpdb->query($query);
    }

    static function remove_post_types()
    {
        $posts = get_posts([
            'post_type'   => ['promotion'],
            'numberposts' => -1,
        ]);

        if (empty($posts)) {
            return;
        }

        foreach ($posts as $post) {
            wp_delete_post($post->ID, true);
        }
    }

    static function clear_after_uninstall()
    {
        self::drop_table(RAFFLE_PREFIX . '_stripe_payments');
        self::remove_post_types();
    }
}