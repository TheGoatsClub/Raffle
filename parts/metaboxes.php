<?php
if (empty($post)) {
    return;
}

$fields = get_post_meta($post->ID, '', true);
?>

<table class="form-table wop-metabox">
    <tbody>
    <tr>
        <th>
            <label for="raffle_text">
                <?php _e('Text', RAFFLE_DOMAIN) ?>
            </label>
        </th>
        <td>
            <input type="text"
                   name="raffle_text"
                   id="raffle_text"
                   value="<?php echo esc_attr($fields['raffle_text'][0] ?? ''); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="raffle_date_start">
                <?php _e('Start Date', RAFFLE_DOMAIN) ?>
            </label>
        </th>
        <td>
            <input type="date"
                   name="raffle_date_start"
                   id="raffle_date_start"
                   value="<?php echo esc_attr($fields['raffle_date_start'][0] ?? ''); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="raffle_date_end">
                <?php _e('End Date', RAFFLE_DOMAIN) ?>
            </label>
        </th>
        <td>
            <input type="date"
                   name="raffle_date_end"
                   id="raffle_date_end"
                   value="<?php echo esc_attr($fields['raffle_date_end'][0] ?? ''); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="raffle_content">
                <?php _e('Content', RAFFLE_DOMAIN) ?>
            </label>
        </th>
        <td>
            <?php
            wp_editor(
                $fields['raffle_content'][0] ?? '',
                'raffle_content',
                [
                    'textarea_name' => 'raffle_content',
                    'textarea_rows' => 15
                ]
            ); ?>
        </td>
    </tr>
    </tbody>
</table>
