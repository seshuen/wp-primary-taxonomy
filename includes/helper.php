<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit; 

/**
 * Add meta box to change the primary taxonomy for the page.
 *
 * @param post $post The post object
 */
function wp_primary_taxonomy_add_meta_boxes( $post ) {
    $allowed_post_types = get_option('wp_primary_taxonomy_options');
    
    add_meta_box('primarycategorydiv', 'WP Primary Taxonomy', 'wp_primary_taxonomy_build_meta_box', $allowed_post_types, 'side', 'core');
}
add_action('add_meta_boxes', 'wp_primary_taxonomy_add_meta_boxes');

/**
 * Build the meta box for primary taxonomy
 *
 * @param post $post The post object
 */
function wp_primary_taxonomy_build_meta_box($post) {
	wp_nonce_field(basename(__FILE__), 'primary_taxonomy_meta_box_nonce');

    $_primary_taxonomy = get_post_meta($post->ID, '_primary_taxonomy', true);
    $post_categories = wp_get_post_categories($post->ID);
    $primary_taxonomy = (empty($_primary_taxonomy)) ? 0 : $_primary_taxonomy;
	?>
    <div class='components-panel__row'>
        <div class="components-base-control">
            <div class="components-base-control__field">
                <select name="wp_primary_taxonomy" id="wp_primary_taxonomy" class="components-select-control__input">
        
                    <?php if($primary_taxonomy === 0): ?>
                        <option value="0"><?php _e('Select primary category...', 'wp-primary-category'); ?></option>
                    <?php endif; ?>
                    <?php foreach($post_categories as $c):
                            $category = get_category( $c ); ?>
                            <option value="<?php echo esc_attr($category->term_id); ?>" <?php if($primary_taxonomy === $category->term_id) { echo esc_attr("selected"); } ?>><?php echo esc_attr($category->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <p class="components-panel__body-title">
                <small>
                    <?php echo 'Select the taxonomy that you wish to set as primary for the post'; ?>
                </small>
            <p>
        </div>
	</div>
	<?php
}

/**
 * Save the primary taxonomy
 *
 * @param int $post_id The post ID
 */
function wp_primary_taxonomy_save_post($post_id) {
    // Verify nonce for the select field 
    if (!isset($_POST['primary_taxonomy_meta_box_nonce']) || !wp_verify_nonce($_POST['primary_taxonomy_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    // Exit if its autosaving
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Exit if user is not authorized to save primary taxonomy
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the primary taxonomy
    if (isset($_POST['wp_primary_taxonomy'])) {
        update_post_meta($post_id, '_primary_taxonomy', sanitize_text_field($_POST['wp_primary_taxonomy']));
    }
}
add_action('save_post', 'wp_primary_taxonomy_save_post');
