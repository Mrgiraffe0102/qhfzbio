<?php
/**
 * Theme hooks
 *
 * @package QHFZBIO
 */

/**
 * HEADER HOOKS
*/

// Before wp_head hook
function MrGiraffe_header_hook() {
    do_action( 'MrGiraffe_header_hook' );
}
// Meta hook
function MrGiraffe_meta_hook() {
    do_action( 'MrGiraffe_meta_hook' );
}

// Post formats meta hook
function MrGiraffe_meta_format_hook() {
    do_action( 'MrGiraffe_meta_format_hook' );
}

// Before wrapper
function MrGiraffe_body_hook() {
    do_action( 'MrGiraffe_body_hook' );
}

// After <header id="header">
function MrGiraffe_mobilemenu_hook() {
    do_action( 'MrGiraffe_mobilemenu_hook' );
}

// Inside branding
function MrGiraffe_branding_hook() {
    do_action( 'MrGiraffe_branding_hook' );
}

// Inside branding
function MrGiraffe_header_socials_hook() {
    do_action( 'MrGiraffe_header_socials_hook' );
}

// Inside branding
function MrGiraffe_topmenu_hook() {
    do_action( 'MrGiraffe_topmenu_hook' );
}

// Inside header image
function MrGiraffe_headerimage_hook() {
    do_action( 'MrGiraffe_headerimage_hook' );
}

// Inside header for widgets
function MrGiraffe_header_widget_hook() {
    do_action( 'MrGiraffe_header_widget_hook' );
}

// Inside access
function MrGiraffe_access_hook() {
    do_action( 'MrGiraffe_access_hook' );
}

// Inside main
function MrGiraffe_main_hook() {
    do_action( 'MrGiraffe_main_hook' );
}

// Breadcrumbs
function MrGiraffe_breadcrumbs_hook() {
    do_action( 'MrGiraffe_breadcrumbs_hook' );
}

/**
 * FOOTER HOOKS
*/

// Footer hook is handled in core master footer

// Master Footer hook
function MrGiraffe_master_footer_hook() {
	do_action( 'MrGiraffe_master_footer_hook' );
}

// Master Footer bottom hook
function MrGiraffe_master_footerbottom_hook() {
	do_action( 'MrGiraffe_master_footerbottom_hook' );
}

// Master Footer top hook
function MrGiraffe_master_topfooter_hook() {
	do_action( 'MrGiraffe_master_topfooter_hook' );
}

/**
 * SIDEBAR HOOKS
*/

function MrGiraffe_before_primary_widgets_hook() {
    do_action( 'MrGiraffe_before_primary_widgets_hook' );
}

function MrGiraffe_after_primary_widgets_hook() {
    do_action( 'MrGiraffe_after_primary_widgets_hook' );
}

function MrGiraffe_before_secondary_widgets_hook() {
    do_action( 'MrGiraffe_before_secondary_widgets_hook' );
}

function MrGiraffe_after_secondary_widgets_hook() {
    do_action( 'MrGiraffe_after_secondary_widgets_hook' );
}

/**
 * LOOP HOOKS
*/

// Post featured image hook
function MrGiraffe_featured_hook() {
	do_action( 'MrGiraffe_featured_hook' );
}

// Metas in the Post featured image hook
function MrGiraffe_featured_meta_hook() {
	do_action( 'MrGiraffe_featured_meta_hook' );
}

// Continue reading link hook
function MrGiraffe_post_excerpt_hook() {
	do_action( 'MrGiraffe_post_excerpt_hook' );
}

// Before each article hook
function MrGiraffe_before_article_hook() {
    do_action( 'MrGiraffe_before_article_hook' );
}

// After each article hook
function MrGiraffe_after_article_hook() {
    do_action( 'MrGiraffe_after_article_hook' );
}

// After each article title
function MrGiraffe_post_title_hook() {
    do_action( 'MrGiraffe_post_title_hook' );
}

// Before header titles meta
function MrGiraffe_headertitle_topmeta_hook() {
    do_action( 'MrGiraffe_headertitle_topmeta_hook' );
}

// After header titles meta
function MrGiraffe_headertitle_bottommeta_hook() {
    do_action( 'MrGiraffe_headertitle_bottommeta_hook' );
}

// After each post meta
function MrGiraffe_post_meta_hook() {
    do_action( 'MrGiraffe_post_meta_hook' );
}

// After post content
function MrGiraffe_post_utility_hook() {
    do_action( 'MrGiraffe_post_utility_hook' );
}

// Before the actual post content on blog pages (content.php)
function MrGiraffe_before_inner_hook() {
    do_action( 'MrGiraffe_before_inner_hook' );
}

// After the actual post content on blog pages (content.php)
function MrGiraffe_after_inner_hook() {
    do_action( 'MrGiraffe_after_inner_hook' );
}

// Before the actual post content on pages and posts (single.php and content-page.php)
function MrGiraffe_singular_before_inner_hook() {
    do_action( 'MrGiraffe_singular_before_inner_hook' );
}

// Before comments (single.php)
function MrGiraffe_singular_before_comments_hook() {
    do_action( 'MrGiraffe_singular_before_comments_hook' );
}

// After the actual post content on pages and posts (single.php and content-page.php)
function MrGiraffe_singular_after_inner_hook() {
    do_action( 'MrGiraffe_singular_after_inner_hook' );
}

// After the actual post content
function MrGiraffe_post_after_content_hook() {
    do_action( 'MrGiraffe_post_after_content_hook' );
}

/**
 * CONTENT HOOKS
 */

function MrGiraffe_before_content_hook() {
    do_action( 'MrGiraffe_before_content_hook' );
}

function MrGiraffe_after_content_hook() {
    do_action( 'MrGiraffe_after_content_hook' );
}

function MrGiraffe_empty_page_hook() {
    do_action( 'MrGiraffe_empty_page_hook' );
}

function MrGiraffe_absolute_top_hook() {
    do_action( 'MrGiraffe_absolute_top_hook' );
}

function MrGiraffe_absolute_bottom_hook() {
    do_action( 'MrGiraffe_absolute_bottom_hook' );
}

/* FIN */
