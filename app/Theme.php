<?php

require get_template_directory() . '/app/Callback.php';

class Theme
{

    private function actionAfterSetup($function)
    {
        add_action('after_setup_theme', function () use ($function) {
            $function();
        });
    }

    private function actionEnqueueScripts($function)
    {
        add_action('wp_enqueue_scripts', function () use ($function) {
            $function();
        });
    }

    // Remove Admin bar
    function remove_admin_bar()
    {
        return false;
    }

    public function __construct()
    {
        $callback = new Callback;

        $this
            // Registers theme support for a given feature.
            ->addSupport('title-tag')
            ->addSupport('custom-logo')
            ->addSupport('custom_header')
            ->addSupport('menus')
            ->addSupport('automatic-feed-links')
            ->addSupport('post-thumbnails')
            ->addSupport('customize-selective-refresh-widgets')
            ->addSupport('html5', [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            ])
            // Enable Threaded Comments
            ->addCommentScript()
            // Enqueue a stylesheet if $src is provided after registering it.
            ->addStyle('normalize', get_template_directory_uri() . '/css/normalize.css', array(), '1.0', 'all')
            ->addStyle('fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css', array(), '5.5.0', 'all')
            ->addStyle('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.0', 'all')
            // Enqueue a script if $src is provided after registering it.
            ->addScript('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0')
            ->addScript('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1')
            ->addScript('jquery', get_template_directory_uri() . '/js/lib/jquery.min.js', array(), '3.3.1')
            ->addScript('bootstrap', get_template_directory_uri() . '/js/lib/bootstrap.min.js', array(), '4.0.0')
            // Hook a function or method to a specific filter action.
            ->addFilter('show_admin_bar', array($callback, 'remove_admin_bar'))
            ->addFilter('avatar_defaults', array($callback, 'theme_default_avatar'))
            ->addFilter('body_class', array($callback, 'add_slug_to_body_class'))
            ->addFilter('widget_text', 'do_shortcode')
            ->addFilter('widget_text', 'shortcode_unautop')
            ->addFilter('the_category', array($callback, 'remove_category_rel_from_category_list'))
            ->addFilter('the_excerpt', 'do_shortcode')
            ->addFilter('the_excerpt', 'shortcode_unautop')
            ->addFilter('style_loader_tag', array($callback, 'theme_style_remove'))
            ->addFilter('post_thumbnail_html', array($callback, 'remove_thumbnail_dimensions'), 10)
            ->addFilter('image_send_to_editor', array($callback, 'remove_thumbnail_dimensions'), 10)
            // Removes a function from a specified filter hook.
            ->removeFilter('the_excerpt', 'wpautop')
            // Removes a function from a specified action hook.
            ->removeAction('wp_head', 'feed_links_extra', 3) // Display the links to the extra feeds such as category feeds
            ->removeAction('wp_head', 'feed_links', 2) // Display the links to the general feeds: Post and Comment Feed
            ->removeAction('wp_head', 'rsd_link') // Display the link to the Really Simple Discovery service endpoint, EditURI link
            ->removeAction('wp_head', 'wlwmanifest_link') // Display the link to the Windows Live Writer manifest file.
            ->removeAction('wp_head', 'index_rel_link') // Index link
            ->removeAction('wp_head', 'parent_post_rel_link', 10, 0) // Prev link
            ->removeAction('wp_head', 'start_post_rel_link', 10, 0) // Start link
            ->removeAction('wp_head', 'adjacent_posts_rel_link', 10, 0) // Display relational links for the posts adjacent to the current post.
            ->removeAction('wp_head', 'wp_generator') // Display the XHTML generator that is generated on the wp_head hook, WP version
            ->removeAction('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0)
            ->removeAction('wp_head', 'rel_canonical')
            ->removeAction('wp_head', 'wp_shortlink_wp_head', 10, 0)
            ;
    }

    public function addFilter($feature, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actionAfterSetup(function () use ($feature, $callback, $priority, $accepted_args) {
            if ($callback) {
                add_filter($feature, $callback, $priority, $accepted_args);
            }
        });
        return $this;
    }

    public function removeFilter($feature, $callback, $priority = 10)
    {
        $this->actionAfterSetup(function () use ($feature, $callback, $priority) {
            if ($callback) {
                remove_filter($feature, $callback, $priority);
            }
        });
        return $this;
    }

    public function addSupport($feature, $options = null)
    {
        $this->actionAfterSetup(function () use ($feature, $options) {
            if ($options) {
                add_theme_support($feature, $options);
            } else {
                add_theme_support($feature);
            }
        });
        return $this;
    }

    public function removeSupport($feature)
    {
        $this->actionAfterSetup(function () use ($feature) {
            remove_theme_support($feature);
        });
        return $this;
    }

    public function loadTextDomain($domain, $path = false)
    {
        $this->actionAfterSetup(function () use ($domain, $path) {
            load_theme_textdomain($domain, $path);
        });
        return $this;
    }

    public function addImageSize($name, $width = 0, $height = 0, $crop = false)
    {
        $this->actionAfterSetup(function () use ($name, $width, $height, $crop) {
            add_image_size($name, $width, $height, $crop);
        });
        return $this;
    }

    public function removeImageSize($name)
    {
        $this->actionAfterSetup(function () use ($name) {
            remove_image_size($name);
        });
        return $this;
    }

    public function addStyle($handle, $src = '',  $deps = array(), $ver = false, $media = 'all')
    {
        $this->actionEnqueueScripts(function () use ($handle, $src, $deps, $ver, $media) {
            wp_enqueue_style($handle,  $src,  $deps, $ver, $media);
        });
        return $this;
    }

    public function addScript($handle,  $src = '',  $deps = array(), $ver = false, $in_footer = false)
    {
        $this->actionEnqueueScripts(function () use ($handle, $src, $deps, $ver, $in_footer) {
            wp_enqueue_script($handle, $src,  $deps, $ver, $in_footer);
        });
        return $this;
    }

    public function addCommentScript()
    {
        $this->actionEnqueueScripts(function () {
            if (is_singular() && comments_open() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        });
        return $this;
    }

    public function removeStyle($handle)
    {
        $this->actionEnqueueScripts(function () use ($handle) {
            wp_dequeue_style($handle);
            wp_deregister_style($handle);
        });
        return $this;
    }

    public function removeScript($handle)
    {
        $this->actionEnqueueScripts(function () use ($handle) {
            wp_dequeue_script($handle);
            wp_deregister_script($handle);
        });
        return $this;
    }

    public function addNavMenus($locations = array())
    {
        $this->actionAfterSetup(function () use ($locations) {
            register_nav_menus($locations);
        });
        return $this;
    }

    public function addNavMenu($location, $description)
    {
        $this->actionAfterSetup(function () use ($location, $description) {
            register_nav_menu($location, $description);
        });
        return $this;
    }

    public function removeNavMenu($location)
    {
        $this->actionAfterSetup(function () use ($location) {
            unregister_nav_menu($location);
        });
        return $this;
    }

    public function registerPostType($handle, $args)
    {
        $this->actionAfterSetup(function () use ($handle, $args) {
            register_post_type($handle, $args);
        });
        return $this;
    }

    public function registerTaxonomyForObjectType($taxonomy, $object_type)
    {
        $this->actionAfterSetup(function () use ($taxonomy, $object_type) {
            register_taxonomy_for_object_type($taxonomy, $object_type);
        });
        return $this;
    }

    public function addAction($feature, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actionAfterSetup(function () use ($feature, $callback, $priority, $accepted_args) {
            add_action($feature, $callback, $priority, $accepted_args);
        });
        return $this;
    }

    public function removeAction($feature, $callback, $priority = 10)
    {
        $this->actionAfterSetup(function () use ($feature, $callback, $priority) {
            remove_action($feature, $callback, $priority);
        });
        return $this;
    }
}
 