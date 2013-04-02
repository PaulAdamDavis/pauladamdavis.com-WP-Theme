<?php

    /*****
        Post-Format Meta Boxes
        ---
        I'm opting here to show all meta boxes for all post formats.
        I will add a moe elegant solution one day, when I figure out the best way to do it.
    *****/

    add_action('add_meta_boxes', 'link_meta');
    function link_meta() {
        add_meta_box('link-meta', 'Link Data', 'link_meta_html', 'post', 'normal', 'high');
    }

    function link_meta_html($post) {

        // Nonce to verify intention later
        wp_nonce_field('save_link_meta', 'link_nonce');

        // Get values for filling in the inputs if we have them.
        $link_url = get_post_meta($post->ID, 'link_url', true);

        ?>

        <table style="width: 100%;">
            <tr>
                <td><label for="link_url">Url</label></td>
                <td><input type="text" style="width: 100%;" id="link_url" name="link_url" value="<?php echo $link_url;?>" /></td>
            </tr>
        </table>

        <?php

    }

    add_action('save_post', 'link_meta_save');
    function link_meta_save( $id ) {

        // If various things, skip saving
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!isset($_POST['link_nonce']) || !wp_verify_nonce($_POST['link_nonce'], 'save_link_meta')) return;
        if (!current_user_can('edit_post')) return;

        // Save the data
        if (isset($_POST['link_url'])) update_post_meta($id, 'link_url', esc_attr(strip_tags($_POST['link_url'])));

    }