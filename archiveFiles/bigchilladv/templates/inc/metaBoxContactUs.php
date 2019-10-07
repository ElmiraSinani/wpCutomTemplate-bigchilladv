<?php

function contacts_add_meta_boxes_page() {
    global $post;
    $contactTpl = "contact-us-page-template.php";
    $pageTpl = basename(get_post_meta($post->ID, '_wp_page_template', true));

    if ($contactTpl == $pageTpl) {
        add_meta_box('contacts_meta_boxe', 'Contact Us Page Settings', 'contacts_meta_box_callback', 'page', 'normal', 'high');
    }
}

add_action('add_meta_boxes_page', 'contacts_add_meta_boxes_page');

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function contacts_meta_box_callback($post) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field('contacts_meta_box', 'contacts_meta_box_nonce');

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */

    $formSubTitle = get_post_meta($post->ID, '_sub_title_val', true);
    $formDescription = get_post_meta($post->ID, '_description_val', true);
    $formID = get_post_meta($post->ID, '_form_id_val', true);
    ?>
    <style type="text/css">
        .cptItem label{font-weight:bold;width:20%;padding-right: 1%;display: inline-block; float: left;}
        .cptItem input[type='text'], .cptItem textarea{width: 75%;}
    </style>
    <?php

    echo '<p class="cptItem"><label for="sub_title_field">';
    _e('Contact Form Title', 'bca');
    echo '</label> ';
    echo '<input type="text" id="sub_title_field" name="sub_title_field" value="' . esc_attr($formSubTitle) . '" /></p>';

    echo '<p class="cptItem"><label for="description_field">';
    _e('Contact Form Description', 'bca');
    echo '</label> ';
    echo '<textarea rows="5" cols="5" id="description_field" name="description_field"  />' . esc_attr($formDescription) . '</textarea></p>';
    
    echo '<p class="cptItem"><label for="form_id_field">';
    _e('Contact Form Shortcode', 'bca');
    echo '</label> ';
    echo '<input type="text" id="form_id_field" name="form_id_field" value="' . esc_attr($formID) . '" /></p>';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function contacts_save_meta_box_data($post_id) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if (!isset($_POST['contacts_meta_box_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['contacts_meta_box_nonce'], 'contacts_meta_box')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {

        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if (!isset($_POST['sub_title_field'])) {
        return;
    }
    if (!isset($_POST['description_field'])) {
        return;
    }
    if (!isset($_POST['form_id_field'])) {
        return;
    }

    // Sanitize user input.
    $sub_title_data = isset($_POST['sub_title_field']) ? sanitize_text_field($_POST['sub_title_field']) : "";
    $desctiption_data = isset($_POST['sub_title_field']) ? sanitize_text_field($_POST['description_field']) : "";
    $form_id_data = isset($_POST['form_id_field']) ? sanitize_text_field($_POST['form_id_field']) : "";

    // Update the meta field in the database.
    update_post_meta($post_id, '_sub_title_val', $sub_title_data);
    update_post_meta($post_id, '_description_val', $desctiption_data);
    update_post_meta($post_id, '_form_id_val', $form_id_data);
}

add_action('save_post', 'contacts_save_meta_box_data');
