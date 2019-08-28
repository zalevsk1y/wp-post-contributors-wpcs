<?php
/*
Plugin Name: wp-post-contributors-wpcs
Plugin URI: https://github.com/zalevsk1y/wp-post-contributors
Description: Add contributors to the post..
Version: 1.0.0
Author: Evgeny S.Zalevskiy <2600@ukr.net>
Author URI: https://github.com/zalevsk1y/
License: MIT
 */
?>
<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'CONTRIBUTORS_PLUGIN_VERSION', '1.0.0' );
define( 'CONTRIBUTORS_PLUGIN_SLUG', 'wp-post-contributors' );
define( 'CONTRIBUTORS_PLUGIN_NAMESPACE', 'ContributorsPlugin' );
define( 'CONTRIBUTORS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CONTRIBUTORS_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'CONTRIBUTORS_PLUGIN_NONCE', 'wp_contributors_plugin_nonce' );
define( 'CONTRIBUTORS_PLUGIN_NONCE_ACTION', 'wp_contributors_plugin_nonce_action' );
define( 'CONTRIBUTORS_PLUGIN_INPUT_FIELD', 'wp_contributors_plugin_value[]' );
define( 'CONTRIBUTORS_PLUGIN_FIELD', 'wp_contributors_plugin_value' );
define( 'CONTRIBUTORS_PLUGIN_META', '_wp_contributors_plugin' );

require_once 'autoload.php';
$admin_template_path       = CONTRIBUTORS_PLUGIN_DIR . '/templates/contributors-plugin-admin-template.php';
$post_template_path        = apply_filters( 'contributors_plugin_post_template', CONTRIBUTORS_PLUGIN_DIR . '/templates/contributors-plugin-post-template.php' );
$modules                   = [];
$modules['admin_template'] = new Contributors_Plugin_Template_Render( $admin_template_path );
$modules['post_template']  = new Contributors_Plugin_Template_Render( $post_template_path );
$modules['metabox']        = new Contributors_Plugin_Metabox_Controller( $modules['admin_template'], $modules['post_template'] );
$modules['main']           = new Contributors_Plugin_Core_Main();
