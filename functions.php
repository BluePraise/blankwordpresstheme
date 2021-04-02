<?php
/******
 * TODO:
 * 1. Init Menu
 */

function theme_features() {
    add_theme_support(
        'title-tag'
    );
}

add_action( 'after_theme_setup', 'theme_features' );

 /***
  * Resources:
  *  https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/
  */
 /**
 * Dequeue a lot of css
 */
function blankttheme_dequeue_style()
{
    if(!is_admin()) {
        wp_dequeue_style('dashicons-css');
        wp_deregister_style('dashicons-css');
        wp_dequeue_style('wp-block-library-theme');
	    wp_deregister_style('wp-block-library-theme');
        wp_dequeue_style('storefront-gutenberg-blocks');
	    wp_deregister_style('storefront-gutenberg-blocks');
        wp_dequeue_style('wp-block-library');
	    wp_deregister_style('wp-block-library');
    }
}
add_action('wp_enqueue_scripts', 'blankttheme_dequeue_style', 999);


function blanktheme_styles_scripts()
{
	wp_register_style('blank-styles', get_stylesheet_directory_uri() . '/style.css');
	wp_register_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
	wp_enqueue_style('blank-styles');
	wp_enqueue_style('animate');
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui');
	wp_enqueue_script('masonry');

	wp_enqueue_script('blank-script', get_theme_file_uri() . '/js/script.js', [], null, true);

	// $ajax_url = admin_url('admin-ajax.php');
	// wp_localize_script(
	// 	'artezpress-script',
	// 	'artez_object',
	// 	array(
	// 		'ajax_url' => $ajax_url,
	// 		'nonce' => wp_create_nonce('ajax-nonce')
	// 	)
	// );
}
add_action('wp_enqueue_scripts', 'blanktheme_styles_scripts');

/**
 * Disable the emoji's
 */
function disable_emojis() {
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
function disable_emojis_tinymce($plugins) {
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
function disable_emojis_remove_dns_prefetch($urls, $relation_type) {
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


/*Contact form 7 remove span*/
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

    $content = str_replace('<br />', '', $content);

    return $content;
});


// allow svg upload
function my_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_types;
}
add_filter('upload_mimes', 'my_myme_types');



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
