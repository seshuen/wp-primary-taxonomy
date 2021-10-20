<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

function wp_primary_taxonomy_settings() { ?>
	<div class="wrap">
		<h2><?php echo esc_html('WP Primary Taxonomy Settings'); ?></h2>

        <?php $settings_tab = isset($_GET['tab']) ? $_GET['tab'] : 'settings'; ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('admin.php?page=wp_primary_taxonomy_settings&amp;tab=settings'); ?>" class="nav-tab <?php echo $settings_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php  echo  esc_html('General Settings'); ?></a>
            <a href="<?php echo admin_url('admin.php?page=wp_primary_taxonomy_settings&amp;tab=documentation'); ?>" class="nav-tab <?php echo $settings_tab == 'documentation' ? 'nav-tab-active' : ''; ?>"><?php echo  esc_html('Documentation'); ?></a>
        </h2>

        <?php if ((string) $settings_tab === 'settings') {
            if (isset($_POST['save_post_types']) && current_user_can('manage_options')) {
                // Sanitize the options field and save the field value
                $wp_primary_taxonomy_options = array_map('sanitize_text_field', $_POST['wp_primary_taxonomy']);
                update_option('wp_primary_taxonomy_options', $wp_primary_taxonomy_options);

                echo '<div class="updated notice is-dismissible"><p>' . esc_html('Settings updated!') . '</p></div>';
            }
            ?>
            <form method="post" action="">
                <h3><?php echo esc_html('List of post types for which primary taxonomy is enabled'); ?></h3>

                <p><span class="dashicons dashicons-editor-help"></span> <?php echo esc_html('Select one or more post types from the list below to allow primary taxonomy selection.'); ?></p>
                <p>
                    <?php
                    $allowed_post_types = get_option('wp_primary_taxonomy_options');
                    $post_types = get_post_types();

                    foreach ($post_types as $post_type):
                        $post_type_object = get_post_type_object($post_type);
                        if(empty($allowed_post_types)){
                            $checked = '';
                        } else {
                            $checked = (in_array($post_type, $allowed_post_types) ? 'checked' : ''); 
                        } ?>
                        <input type="checkbox" id="enable_primary_taxonomy_<?php echo $post_types; ?>" name="wp_primary_taxonomy[]" value="<?php echo $post_type; ?>" <?php echo $checked; ?>>
                        <label for="enable_primary_taxonomy_<?php echo $post_type; ?>"><?php echo $post_type_object->labels->singular_name; ?></label>
                        <br />
                    <?php endforeach; ?>
                </p>

                <p><input type="submit" name="save_post_types" class="button button-primary" value="<?php echo esc_html('Save Changes'); ?>"></p>
            </form>
            <?php
        } else if ((string) $settings_tab === 'documentation') { ?>
            <h3><?php echo esc_html('Developer Notes on how to use'); ?></h3>

            <p><?php echo esc_html('Use native WordPress queries to get posts based on their primary taxonomy ID. Like the example below.'); ?></p>
            <p>
                <textarea class="large-text code" rows="24">
                    $args = array(
                        'meta_query' => array(
                            array(
                                'key' => '_primary_taxonomy',
                                'value' => array(<taxonomy-ids>),
                                'compare' => 'IN',
                            ),
                        ),
                    );
                    $custom_wp_query = new WP_Query($args);

                    if ($custom_wp_query->have_posts()) {
                        while ($custom_wp_query->have_posts()) {
                            $custom_wp_query->the_post();

                            $all_post = $custom_wp_query->post;

                            /*
                            * $custom_wp_query->post (or $all_post) is a WP_Post object
                            *
                            * Usage
                            * $custom_wp_query->post->ID (or $all_post->ID)
                            * $custom_wp_query->post->post_title (or $all_post->post_title)
                            * $custom_wp_query->post->post_content (or $all_post->post_content)
                            */
                        }
                    }
                </textarea>
            </p>
            <?php
        }
        ?>
	</div>
<?php
}