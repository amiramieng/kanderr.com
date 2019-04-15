<?php
 /*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/
require get_template_directory() . '/app/Ajax.php';
require get_template_directory() . '/app/theme-support.php';
require get_template_directory() . '/app/widgets.php';
require get_template_directory() . '/app/Theme.php';
require get_template_directory() . '/app/Support.php';

class Kanderr extends Theme
{
    public function __construct()
    {
        //
        $this->addNavMenus([
            'header-menu' => 'Primary',
            'mobile-menu' => 'Mobile',
            'footer-menu' => 'Footer'
        ]);
        //
        $this
        ->addStyle('kanderr', get_template_directory_uri() . '/css/style.css')
        ->addStyle('aos', get_template_directory_uri() . '/css/aos.css')
        ->addScript('kanderr', get_template_directory_uri() . '/js/scripts.js')
        ->addScript('aos', get_template_directory_uri() . '/js/lib/aos.js');
        //
        $this->registerPostType(
            'messages', // Register Custom Post Type
            array(
                'labels' => array(
                    'name' => __('Messages', 'kanderr-theme'), // Rename these to suit
                    'singular_name' => __('Message', 'kanderr-theme'),
                    'menu_name' => __('Messages', 'kanderr-theme'),
                    'name_admin_bar' => __('Message', 'kanderr-theme'),
                ),
                'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'menu_position' => 26,
                'menu_icon' => 'dashicons-email-alt',
                'supports' => array(
                    'title',
                    'editor',
                    'author'
                ), // Go to Dashboard Custom HTML5 Blank post for supports
            )
        );
        $this->registerPostType(
            'film',
            array(
                'labels' => array(
                    'name' => __('Films', 'kanderr-theme'), // Rename these to suit
                    'singular_name' => __('Film', 'kanderr-theme'),
                    'add_new' => __('Add New', 'kanderr-theme'),
                    'add_new_item' => __('Add New Film', 'kanderr-theme'),
                    'edit' => __('Edit', 'kanderr-theme'),
                    'edit_item' => __('Edit Film', 'kanderr-theme'),
                    'new_item' => __('New Film', 'kanderr-theme'),
                    'view' => __('View Film', 'kanderr-theme'),
                    'view_item' => __('View Film', 'kanderr-theme'),
                    'search_items' => __('Search Films', 'kanderr-theme'),
                    'not_found' => __('No Films found', 'kanderr-theme'),
                    'not_found_in_trash' => __('No Films found in Trash', 'kanderr-theme')
                ),
                'public' => true,
                'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
                'menu_icon' => 'dashicons-video-alt',
                'menu_position' => 5,
                'has_archive' => false,
                'supports' => array(
                    'title',
                    'editor',
                    'excerpt',
                    'thumbnail'
                ), // Go to Dashboard Custom HTML5 Blank post for supports
                'can_export' => true, // Allows export in Tools > Export
            )
        )
        ->registerTaxonomyForObjectType('post_tag', 'messages')
        ->registerPostType(
            'team', // Register Custom Post Type
            array(
                'labels' => array(
                    'name' => __('Team', 'kanderr-theme'), // Rename these to suit
                    'singular_name' => __('Team', 'kanderr-theme'),
                    'add_new' => __('Add New', 'kanderr-theme'),
                    'add_new_item' => __('Add New Team Member', 'kanderr-theme'),
                    'edit' => __('Edit', 'kanderr-theme'),
                    'edit_item' => __('Edit Team Member', 'kanderr-theme'),
                    'new_item' => __('New Team Member', 'kanderr-theme'),
                    'view' => __('View Team', 'kanderr-theme'),
                    'view_item' => __('View Team Member', 'kanderr-theme'),
                    'search_items' => __('Search Team Members', 'kanderr-theme'),
                    'not_found' => __('No Team Members found', 'kanderr-theme'),
                    'not_found_in_trash' => __('No Team Members found in Trash', 'kanderr-theme')
                ),
                'public' => true,
                'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
                'has_archive' => false,
                'supports' => array(
                    'title',
                    'editor',
                    'excerpt',
                    'thumbnail'
                ), // Go to Dashboard Custom HTML5 Blank post for supports
                'can_export' => true, // Allows export in Tools > Export
                'taxonomies' => array(
                    // 'category',
                    'post_tag'
                ), // Add Category and Post Tags support
                'menu_position' => 20,
                'menu_icon' => 'dashicons-groups'
            )
        );
        //
        $this->addAction('add_meta_boxes', array($this, 'kanderr_messages_add_meta_box'))
        ->addAction('save_post', array($this, 'kanderr_save_contact_email_data'))
        ->addAction('manage_messages_posts_custom_column', array($this, 'kanderr_messages_custom_column'), 10, 2)
        ->addAction('admin_enqueue_scripts', array($this, 'kanderr_admin_scripts'))
        ->addAction('template_redirect', array($this, 'kanderr_remove_wp_archives'));
        //
        $this->addFilter('manage_messages_posts_columns', array($this, 'kanderr_set_messages_columns'))
        ->addFilter('embed_oembed_html', array($this, 'wrap_embedded_media'), 10, 3)
        ->addFilter('avatar_defaults', array($this, 'kanderr_avatar_defaults'))
        ->addFilter( 'comment_form_default_fields', array($this, 'kanderr_comment_form_fields'))
        ->addFilter( 'comment_form_defaults', array($this, 'kanderr_comment_form_defaults'))
        ;
    }


    public function kanderr_messages_custom_column($column, $post_id)
    {
        switch ($column) {

            case 'message':
                echo get_the_excerpt();
                break;

            case 'email':
                //email column
                $email = get_post_meta($post_id, '_contact_email_value_key', true);
                echo '<a href="mailto:' . $email . '">' . $email . '</a>';
                break;
        }
    }

    public function kanderr_set_messages_columns($columns)
    {
        $newColumns = array();
        $newColumns['title'] = 'Full Name';
        $newColumns['message'] = 'Message';
        $newColumns['email'] = 'Email';
        $newColumns['date'] = 'Date';
        return $newColumns;
    }

    public function kanderr_messages_add_meta_box()
    {
        add_meta_box('contact_email', 'User Email', 'kanderr_contact_email_callback', 'messages', 'side');
    }
    public function kanderr_contact_email_callback($post)
    {
        wp_nonce_field(array($this, 'kanderr_save_contact_email_data'), 'kanderr_contact_email_meta_box_nonce');

        $value = get_post_meta($post->ID, '_contact_email_value_key', true);

        echo '<label for="kanderr_contact_email_field">User Email Address: </label>';
        echo '<input type="email" id="kanderr_contact_email_field" name="kanderr_contact_email_field" value="' . esc_attr($value) . '" size="25" />';
    }
    public function kanderr_save_contact_email_data($post_id)
    {

        if (!isset($_POST['kanderr_contact_email_meta_box_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['kanderr_contact_email_meta_box_nonce'], array($this, 'kanderr_save_contact_email_data'))) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (!isset($_POST['kanderr_contact_email_field'])) {
            return;
        }

        $my_data = sanitize_text_field($_POST['kanderr_contact_email_field']);

        update_post_meta($post_id, '_contact_email_value_key', $my_data);
    }

    public function kanderr_admin_scripts($hook)
    {

        if ('' === $hook) {
            wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
            wp_enqueue_script('scriptname'); // Enqueue it!
        }
    }

    public function wrap_embedded_media($html, $url, $attr)
    {
        return '<div class="embed-16by9">' . $html . '</div>';
    }

    public function kanderr_avatar_defaults($avatar_defaults) {
        $myavatar = get_template_directory_uri() . '/img/kanderr-footer.png';
        $avatar_defaults[$myavatar] = "Kanderr Avatar";
        return $avatar_defaults;
    }

    public function kanderr_comment_form_defaults($defaults)
    {
        $defaults['title_reply'] = __( 'Add Your Story' );
        $defaults['label_submit'] = __( 'Submit Story', 'custom' );
	    return $defaults;
    }

    public function kanderr_comment_form_fields($fields) {
        // var_dump($fields);

        unset($fields['author']);
        unset($fields['email']);
        unset($fields['url']);

        $fields['author'] = '<p class="comment-form-author"><label for="author">' . __( 'Name', 'kanderr-theme' ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="" size="30"></p>';

        $fields['email'] = '<p class="comment-form-email"><label for="email">' . __( 'Email', 'kanderr-theme' ) . ' <span class="required">*</span></label> ' .
        '<input id="email" name="email" type="text" value="" size="30"></p>';

        $fields['url'] = '<p class="comment-form-url"><label for="url">' . __( 'Website', 'kanderr-theme' ) . ' <span class="required">*</span></label> ' .
        '<input id="url" name="url" type="text" value="" size="30"></p>';

        return $fields;
    }

    /* Remove archives */
    public function kanderr_remove_wp_archives(){
        //If we are on category or tag or date or author archive
        if( is_category() || is_tag() || is_date() || is_author() ) {
            wp_redirect( home_url() );
            exit;
        }
    }

}

$theme = new Theme;
$ajax = new Ajax;
$kanderr = new Kanderr;
