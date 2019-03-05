<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

require get_template_directory().'/app/Ajax.php';
require get_template_directory().'/app/theme-support.php';
require get_template_directory().'/app/widgets.php';

require get_template_directory().'/app/Theme.php';
require get_template_directory().'/app/Support.php';

$theme = new Theme;
$ajax = new Ajax;

$theme->addNavMenus([
    'header-menu' => 'Primary',
]);
$theme->addStyle('kanderr', get_template_directory_uri() . '/css/style.css');
$theme->addScript('kanderr', get_template_directory_uri() . '/js/scripts.js');
$theme->registerPostType('messages', // Register Custom Post Type
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
    ));
$theme->addAction( 'add_meta_boxes', 'kanderr_messages_add_meta_box' );
$theme->addAction( 'save_post', 'kanderr_save_contact_email_data' );
$theme->addAction('manage_messages_posts_custom_column', 'kanderr_messages_custom_column', 10, 2);
$theme->addFilter('manage_messages_posts_columns', 'kanderr_set_messages_columns');


function kanderr_messages_custom_column($column, $post_id) {
    switch( $column ){

		case 'message' :
			echo get_the_excerpt();
			break;

		case 'email' :
			//email column
			$email = get_post_meta( $post_id, '_contact_email_value_key', true );
			echo '<a href="mailto:'.$email.'">'.$email.'</a>';
			break;
	}
}

function kanderr_set_messages_columns( $columns ){
	$newColumns = array();
	$newColumns['title'] = 'Full Name';
	$newColumns['message'] = 'Message';
	$newColumns['email'] = 'Email';
	$newColumns['date'] = 'Date';
	return $newColumns;
}

function kanderr_messages_add_meta_box() {
  add_meta_box( 'contact_email', 'User Email', 'kanderr_contact_email_callback', 'messages', 'side' );
}
function kanderr_contact_email_callback( $post ) {
	wp_nonce_field( 'kanderr_save_contact_email_data', 'kanderr_contact_email_meta_box_nonce' );

	$value = get_post_meta( $post->ID, '_contact_email_value_key', true );

	echo '<label for="kanderr_contact_email_field">User Email Address: </label>';
	echo '<input type="email" id="kanderr_contact_email_field" name="kanderr_contact_email_field" value="' . esc_attr( $value ) . '" size="25" />';
}
function kanderr_save_contact_email_data( $post_id ) {

	if( ! isset( $_POST['kanderr_contact_email_meta_box_nonce'] ) ){
		return;
	}

	if( ! wp_verify_nonce( $_POST['kanderr_contact_email_meta_box_nonce'], 'kanderr_save_contact_email_data') ) {
		return;
	}

	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return;
	}

	if( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if( ! isset( $_POST['kanderr_contact_email_field'] ) ) {
		return;
	}

	$my_data = sanitize_text_field( $_POST['kanderr_contact_email_field'] );

	update_post_meta( $post_id, '_contact_email_value_key', $my_data );

}