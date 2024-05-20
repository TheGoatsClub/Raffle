<div class="wrap">
    <h1>
        <?php _e('Raffle Settings', RAFFLE_DOMAIN) ?>
    </h1>

    <form method="post" action="options.php">
        <?php settings_fields('raffle-settings-group'); ?>
        <?php do_settings_sections('raffle-settings-group'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="raffle_stripe_publishable_key">
                        <?php _e('Stripe Publishable key', RAFFLE_DOMAIN) ?>
                    </label>
                </th>
                <td>
                    <input type="password"
                           class="regular-text"
                           name="raffle_stripe_publishable_key"
                           id="raffle_stripe_publishable_key"
                           value="<?php echo esc_attr(get_option('raffle_stripe_publishable_key')); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="raffle_stripe_secret_key">
                        <?php _e('Stripe Secret key', RAFFLE_DOMAIN) ?>
                    </label>
                </th>
                <td>
                    <input type="password"
                           class="regular-text"
                           name="raffle_stripe_secret_key"
                           id="raffle_stripe_secret_key"
                           value="<?php echo esc_attr(get_option('raffle_stripe_secret_key')); ?>">
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>