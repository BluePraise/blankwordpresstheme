<?php

    // Load styles
    function blankpress_styles() {

            // Custom CSS
            wp_register_style( 'blankpress', get_template_directory_uri() . '/style.css' );

            // Register CSS
            wp_enqueue_style( 'blankpress' );

    }


    // Add Actions
    // Add Custom Scripts to wp_head
    // add_action( 'wp_enqueue_scripts', 'gogo_header_scripts' );
    // Add Theme Stylesheet
    add_action( 'wp_enqueue_scripts', 'blankpress_styles' );
    // Add Menu
    // add_action( 'init', 'register_gogo_menu' );


    // Remove Actions
    remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
    remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
    remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
    remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
    remove_action( 'wp_head', 'rel_canonical' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

?>
