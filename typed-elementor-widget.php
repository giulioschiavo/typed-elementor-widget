<?php
/**
 * Plugin Name: Typed.js Elementor Widget
 * Description: Integrates Typed.js as an Elementor widget with full styling and animation controls. 
 * Version:     1.0.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 * Author:      Giulio Schiavo
 * Author URI:  https://giulioschiavo.it
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: typed-elementor-widget
 * Domain Path: /languages
 */
 
/**
 * Includes Typed.js library by Matt Boldt.
 * @link https://github.com/mattboldt/typed.js/
 * @license GPLv2 or later
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TYPEELWI_VERSION', '1.0.1' );
define( 'TYPEELWI_PATH', plugin_dir_path( __FILE__ ) );
define( 'TYPEELWI_URL', plugin_dir_url( __FILE__ ) );

add_filter( 'plugin_row_meta', 'typeelwi_plugin_row_meta', 10, 2 );

function typeelwi_plugin_row_meta( $links, $file ) {

	if ( plugin_basename( __FILE__ ) !== $file ) {
		return $links;
	}
	$row_meta = [
		'typedjs' => '<a href="https://github.com/mattboldt/typed.js/" target="_blank" rel="noopener noreferrer">Typed.js by Matt Boldt</a>',
	];
	return array_merge( $links, $row_meta );

}

/**
 * Checks if Elementor is active before proceeding.
 */
final class Typeelwi_Plugin {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	public function init() {
	    load_plugin_textdomain(
        	'typed-elementor-widget',
        	false,
        	dirname( plugin_basename( __FILE__ ) ) . '/languages/'
        
        );
		// Elementor must be active
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
			return;
		}

		// Widget Registration
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Load scripts & styles on frontend
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		// Load scripts also inside Elementor editor
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'elementor/preview/enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public function register_widgets( $widgets_manager ) {
		require_once TYPEELWI_PATH . 'includes/widget-typed.php';
		$widgets_manager->register( new \Typeelwi_Widget_Typed() );
	}

	public function enqueue_scripts() {
		wp_register_script(
        	'typed-js',
        	TYPEELWI_URL . 'assets/js/typed.umd.js',
        	[],
        	'3.0.0',
        	true
        );

		wp_register_script(
			'typeelwi-init',
			TYPEELWI_URL . 'assets/js/typeelwi-init.js',
			[ 'typed-js' ],
			TYPEELWI_VERSION,
			true
		);

		wp_register_style(
			'typeelwi-style',
			TYPEELWI_URL . 'assets/css/typeelwi-style.css',
			[],
			TYPEELWI_VERSION
		);

		wp_enqueue_script( 'typed-js' );
		wp_enqueue_script( 'typeelwi-init' );
		wp_enqueue_style( 'typeelwi-style' );
	}

	public function admin_notice_missing_elementor() {
		$message = sprintf(
			/* translators: %s: Plugin name */
			esc_html__( '"%s" requires Elementor. Please install and activate Elementor before using this plugin.', 'typed-elementor-widget' ),
			'<strong>Typed.js Elementor Widget</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
	}
}

Typeelwi_Plugin::instance();
