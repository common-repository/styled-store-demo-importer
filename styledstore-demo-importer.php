<?php
/**
 * Plugin Name: Styled Store Demo Importer
 * Plugin URI: https://sushilwp.wordpress.com/styled-store-demo-importer/
 * Description: This provides to setup demo of Styled Store Theme
 * Version: 1.0.1
 * Author: StyledThemes
 * Author URI: https://sushilwp.wordpress.com/
 * Requires at least: 4.0
 * Tested up to: 4.8
 * Authors: sushil-adhikari
 *
 * Text Domain: styledstore-demo-importer
 * Domain Path: /languages/
 *
 * @package Styled Store Demo Importer
 * @author Sushil Adhikari
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( ! class_exists( 'Styledstore_Demo_Import' ) ) :
/**
 * Main Styled Store Demo Importer Class.
 *
 * @class Styledstore_Demo_Import
 * @version	1.0.0
 */	
class  Styledstore_Demo_Import {
	/**
	 * The single instance of the class.
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main Styledstore Demo Importer Instance.
	 *
	 * Ensures only one instance of Styledstore_Demo_Import is loaded or can be loaded.
	 * @since 1.0.0
	 * @return Styledstore_Demo_Import - Main instance.
	 */

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * Styledstore_Demo_Import Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();

	}

	/**
	 * Define Styled Store Demo Importer Constants.
	 */
	private function define_constants() {
		define( 'STYLED_STORE_DEMO_IMPORTER_DIR', plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Define Styled Store Demo Importer Constants.
	 */
	private function includes() {
		include_once( STYLED_STORE_DEMO_IMPORTER_DIR . 'tgmpa/example.php' );
	}

	/**
	* Hooks in to action and filter
	* @since version 1.0
	*/
	public function init_hooks() {
		add_action( 'init', array( $this, 'sdi_load_plugin_textdomain' ) );
		add_filter( 'pt-ocdi/import_files', array( $this, 'styledstore_demo_importer_defined_files' ) );
		add_action( 'pt-ocdi/after_import', array( $this, 'styledstore_demo_importer_after_import_setup' ) );
	}

	/**
	* @return Load plugin text domain
	*/
	public function sdi_load_plugin_textdomain() {
		load_plugin_textdomain( 'styledstore-demo-importer', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	/**
	 * @return predefined demo import files
	 * @version 1.0.0
	 */
	function styledstore_demo_importer_defined_files() {
	  	return array(
		    array(
				'import_file_name'             => esc_html__( 'Styled Store Demo Import', 'styledstore-demo-importer' ),
				'local_import_file'            => trailingslashit( STYLED_STORE_DEMO_IMPORTER_DIR ) . 'demo-importer/content-data.xml',
				'local_import_widget_file'     => trailingslashit( STYLED_STORE_DEMO_IMPORTER_DIR ) . 'demo-importer/widgets-data.wie',
				'local_import_customizer_file' => trailingslashit( STYLED_STORE_DEMO_IMPORTER_DIR ) . 'demo-importer/customizer-data.dat',
			)

	  	);
	}

	/**
	 * @return set front page and menus locations
	 * @version 1.0
	 */
	public function styledstore_demo_importer_after_import_setup() {
	    // Assign menus to their locations.
	    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

	    set_theme_mod( 'nav_menu_locations', array(
	            'primary' => $main_menu->term_id,
	            'mobile' => $main_menu->term_id
	        )
	    );

	    // Assign front page and posts page (blog page).
	    $front_page_id = get_page_by_title( 'HOME' );
	    $blog_page_id  = get_page_by_title( 'Blog' );

	    update_option( 'show_on_front', 'page' );
	    update_option( 'page_on_front', $front_page_id->ID );
	    update_option( 'page_for_posts', $blog_page_id->ID );

	}


} //end of Styledstore_Demo_Import
endif;

/**
 * Main instance of Styledstore_Demo_Import.
 *
 * Returns the main instance of Styledstore_Demo_Import to prevent the need to use globals.
 *
 * @since  1.0
 * @return Styledstore_Demo_Import
 */
function styledstore_demo_importer() {
	return Styledstore_Demo_Import::instance();
}

$GLOBALS['styledstore-di'] = styledstore_demo_importer();