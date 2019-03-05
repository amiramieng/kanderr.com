<?php

class Callback
{
    
    function remove_admin_bar() {
        return false;
    }

    function theme_default_avatar() {
        $myavatar = get_template_directory_uri() . '/img/avatar.jpg';
        $avatar_defaults[$myavatar] = "Custom Gravatar";
        return $avatar_defaults;
    }

    function add_slug_to_body_class($classes)
    {
        global $post;
        if (is_home()) {
            $key = array_search('blog', $classes);
            if ($key > -1) {
                unset($classes[$key]);
            }
        } elseif (is_page()) {
            $classes[] = sanitize_html_class($post->post_name);
        } elseif (is_singular()) {
            $classes[] = sanitize_html_class($post->post_name);
        }

        return $classes;
    }

    // Remove invalid rel attribute values in the categorylist
    function remove_category_rel_from_category_list($thelist)
    {
        return str_replace('rel="category tag"', 'rel="tag"', $thelist);
    }

    function theme_style_remove($tag)
    {
        return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
    }

    // Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
    function remove_thumbnail_dimensions( $html )
    {
        $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
        return $html;
    }

}

?>