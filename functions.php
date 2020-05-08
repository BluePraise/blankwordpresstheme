<?php
/******
 * TODO:
 * 1. Init Menu
 */


 /***
  * Resources:
  *  https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
  */
    // Load styles
    function blankpress_styles() {

            // Custom CSS
            wp_register_style( 'blankpress', get_template_directory_uri() . '/style.css' );

            // Register CSS
            wp_enqueue_style( 'blankpress' );

    }


    function blankpress_scripts() {

        //wp_register_script( $handle, $src, $deps, $ver, $in_footer );
        // Goes in header
        wp_register_script( 'feather_icons', 'https://unpkg.com/feather-icons', array(), '4.26.0', false);


        // Goes in footer

        wp_register_script( 'blankpress_jquery', 'https://code.jquery.com/jquery-3.4.1.js', array(), '3.4.1', true);
        wp_register_script( 'blankpress_scripts', get_template_directory_uri() .  '/js/script.js', array('jquery'), '0.0', true);

        // wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
        wp_enqueue_script( 'feather_icons' );
        wp_enqueue_script( 'blankpress_jquery' );
        wp_enqueue_script( 'blankpress_scripts' );

    }

/**
 * Disable the emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter(
        'wp_resource_hints',
        'disable_emojis_remove_dns_prefetch',
        10,
        2
    );
}
add_action('init', 'disable_emojis');
/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters(
            'emoji_svg_url',
            'https://s.w.org/images/core/emoji/2/svg/'
        );

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}

function my_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';

    // return
    return $paths;
}

function wpb_remove_version() {
    return '';
}
add_filter('the_generator', 'wpb_remove_version');


// allow svg upload
function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types');



// Add Actions
add_action( 'wp_enqueue_scripts', 'blankpress_scripts' );

// Add Theme Stylesheet
add_action( 'wp_enqueue_scripts', 'blankpress_styles' );

// Add Menu
// add_action( 'init', 'register_blankpress_menu' );

// ACF JSON https://www.advancedcustomfields.com/resources/local-json/
add_filter('acf/settings/load_json', 'my_acf_json_load_point');

// Remove Actions
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

function remove_footer_admin () {

echo 'Need help? <a href="http://www.magalielinda.me" target="_blank">Ask Maggie.</a> | Phone: <a href="tel://0031652841683">0652841683</a></p>';

}
add_filter('admin_footer_text', 'remove_footer_admin');

?>
