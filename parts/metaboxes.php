<?php
if (empty($post)) {
    return;
}

$fields = get_post_meta($post->ID, '', true);
if (!empty($fields['raffle_attachments'][0])) {
    $attachmentIds = unserialize($fields['raffle_attachments'][0]);
}
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
            <label for="raffle_radio">
                <?php _e('Visibility', RAFFLE_DOMAIN) ?>
            </label>
        </th>
        <td>
            <div>
                <div>
                    <label for="raffle_radio_member">
                        <?php _e('For members', RAFFLE_DOMAIN); ?>
                    </label>
                    <input type="radio"
                           name="raffle_radio"
                           id="raffle_radio_member"
                           value="1"
                        <?php checked(1, $fields['raffle_radio'][0] ?? ''); ?>>
                </div>
                <div>
                    <label for="raffle_radio_public">
                        <?php _e('Public', RAFFLE_DOMAIN); ?>
                    </label>
                    <input type="radio"
                           name="raffle_radio"
                           id="raffle_radio_public"
                           value="0"
                        <?php checked(0, $fields['raffle_radio'][0] ?? ''); ?>>
                </div>
            </div>
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
    <tr>
        <td>
            <label for="raffle_content">
                <?php _e('Media', RAFFLE_DOMAIN) ?>
            </label>
        </td>
        <td>
            <div class="raffle_media">
                <div class="raffle_repeater__list">
                    <?php if (!empty($attachmentIds)) { ?>
                        <?php foreach ($attachmentIds as $attachmentId) {
                            $attachmentUrl = wp_get_attachment_image_url($attachmentId, 'small'); ?>
                            <div class="raffle_repeater__item">
                                <div class="raffle_repeater__body">
                                    <p class="raffle_img_item">
                                        <?php if ($attachmentUrl): ?>
                                            <img src="<?php echo $attachmentUrl; ?>" alt="<?php echo get_the_title($attachmentId); ?>">
                                        <?php endif; ?>
                                    </p>

                                    <span class="raffle_attachment_add button">
                                        <?php _e('Add image', RAFFLE_DOMAIN); ?>
                                    </span>

                                    <span class="raffle_attachment_remove button">
                                        <?php _e('Remove image', RAFFLE_DOMAIN); ?>
                                    </span>

                                    <input type="hidden" class="raffle_attachment_id button" name="raffle_attachments[]" value="<?php echo $attachmentId; ?>">
                                </div>
                            </div>
                        <?php } ?> 
                    <?php } else { ?>
                        <div class="raffle_repeater__item">
                            <div class="raffle_repeater__body">
                                <p class="raffle_img_item">
                                    <img src="" alt="">
                                </p>

                                <span class="raffle_attachment_add button">
                                    <?php _e('Add image', RAFFLE_DOMAIN); ?>
                                </span>

                                <span class="raffle_attachment_remove button hidden">
                                    <?php _e('Remove image', RAFFLE_DOMAIN); ?>
                                </span>

                                <input type="hidden" class="raffle_attachment_id button" name="raffle_attachments[]" value="">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="raffle_media_add is-primary button components-button">
                    <?php _e('Add media', RAFFLE_DOMAIN); ?>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
