<?php
/*
Plugin Name: Sample AJAX Plugin for WordCamp Chicago 2012
Plugin URI: http://thomasgriffinmedia.com/
Description: Creates a sample plugin options page that utilizes AJAX to pull data about a plugin from the WordPress Plugin API.
Author: Thomas Griffin
Author URI: http://thomasgriffinmedia.com/
Version: 1.0.0
License: GNU General Public License v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

/*
	Copyright 2012	 Thomas Griffin	 (email : thomas@thomasgriffinmedia.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Sample AJAX class for WordCamp Chicago 2012.
 *
 * @since 1.0.0
 *
 * @package	Sample AJAX Chicago
 * @author	Thomas Griffin
 */
class Sample_Ajax_Chicago {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions and such for the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		/** Store the object in a static property */
		self::$instance = $this;

		/** Hook everything into the plugins_loaded hook */
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		/** Handle our AJAX submissions */
		add_action( 'wp_ajax_get_plugin_data', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_get_plugin_data', array( $this, 'ajax' ) );

	}

	/**
	 * Loads all the stuff to make the plugin run.
	 *
	 * @since 1.0.0
	 */
	public function init() {

		/** Load the plugin textdomain for internationalizing strings */
		load_plugin_textdomain( 'sample-ajax-chicago', false, plugin_dir_path( __FILE__ ) . '/languages/' );

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_shortcode( 'sample-ajax-chicago', array( $this, 'shortcode' ) );

	}

	/**
	 * Registers the scripts for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function scripts() {

		wp_register_script( 'sample-ajax-chicago', plugins_url( '/js/ajax.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

		/** Normally we would stick this in the shortcode itself, but since this theme loads content via AJAX already, we need to have this information already available to process the output because the .load() method is only targeting the #slide div and not the entire document */
		$args = array(
			'error'		=> __( 'An unknown error occurred. Please try again!', 'sample-ajax-chicago' ),
			'nonce'		=> wp_create_nonce( 'sample-ajax-chicago-nonce' ),
			'searching'	=> __( 'Searching...', 'sample-ajax-chicago' ),
			'spinner'	=> admin_url( 'images/loading.gif' ),
			'url'		=> admin_url( 'admin-ajax.php' )
		);
		wp_localize_script( 'sample-ajax-chicago', 'sample_ajax_chicago', $args );
		wp_enqueue_script( 'sample-ajax-chicago' );

	}

	/**
	 * Outputs the shortcode for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function shortcode() {

		/** For all normal themes, we would enqueue and localize our script here before we output our data */

		/** Output the HTML for the sample plugin field and button */
		$output = '';
		$output .= '<div id="sample-plugin-query">';
			$output .= '<div id="search-area" class="left">';
				$output .= '<h3>' . __( 'Input', 'sample-ajax-chicago' ) . '</h3>';
				$output .= '<input type="text" id="plugin-name" size="25" name="plugin-name" value="" placeholder="' . esc_attr__( 'Type a plugin slug here…', 'sample-ajax-chicago' ) . '" />';
				$output .= '<a id="query-api" href="#" class="button">' . __( 'Get Plugin Information', 'sample-ajax-chicago' ) . '</a>';
			$output .= '</div>';
			$output .= '<div id="output-area" class="right">';
				$output .= '<h3>' . __( 'Output', 'sample-ajax-chicago' ) . '</h3>';
				$output .= '<div class="plugin-info">';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		/** Return the output */
		return $output;

	}

	/**
	 * Handles the AJAX request for getting plugin data from the WordPress Plugin API.
	 *
	 * @since 1.0.0
	 */
	public function ajax() {

		/** Do a security check first */
		check_ajax_referer( 'sample-ajax-chicago-nonce', 'nonce' );

		/** Die early if there is no plugin to look for */
		if ( ! isset( $_POST['plugin'] ) || isset( $_POST['plugin'] ) && empty( $_POST['plugin'] ) )
			die( __( 'No plugin was entered in the search!', 'sample-ajax-chicago' ) );

		/** Now that we are verified, let's make our request to get the data */
		if ( ! class_exists( 'WP_Http' ) )
			require( ABSPATH . WPINC . '/class-http.php' );

		/** Args we want to send to the plugin API (the request must be an object) */	
		$args = array( 'slug' => stripslashes( $_POST['plugin'] ) );
		$args = (object) $args;

		$request = wp_remote_post( 
			'http://api.wordpress.org/plugins/info/1.0/', 
			array(
				'timeout'	=> 15,
				'body' 		=> array(
					'action' 	=> 'plugin_information',
					'request' 	=> serialize( $args )
				)
			) 
		);
		$response_code 	= wp_remote_retrieve_response_code( $request );
		$response_body 	= maybe_unserialize( wp_remote_retrieve_body( $request ) );

		/** Bail out early if there are any errors */
		if ( 200 != $response_code || is_wp_error( $response_body ) || is_null( $response_body ) )
			die( __( 'There was an error retrieving the plugin information. The plugin does not exist or the API is down. Please try again!', 'sample-ajax-chicago' ) );

		/** Our response will be an object, so let's make our life easier and format it here instead of using jQuery */		
		$response = '<p class="plugin-response">';
			$response .= __( 'Plugin Name:', 'sample-ajax-chicago' ) . ' <strong>' . esc_attr( $response_body->name ) . '</strong><br />';
			$response .= __( 'Plugin Slug:', 'sample-ajax-chicago' ) . ' <strong>' . esc_attr( $response_body->slug ) . '</strong><br />';
			$response .= __( 'Plugin Version:', 'sample-ajax-chicago' ) . ' <strong>' . esc_attr( $response_body->version ) . '</strong><br />';
			$response .= __( 'Plugin Author:', 'sample-ajax-chicago' ) . ' <strong>' . $response_body->author . '</strong><br />';
			$response .= __( 'Plugin Author Profile:', 'sample-ajax-chicago' ) . ' <a href="' . esc_url( $response_body->author_profile ) . '"><strong>' . esc_url( $response_body->author_profile ) . '</strong></a><br />';
			$response .= __( 'Contributors:', 'sample-ajax-chicago' ) . ' <strong>' . implode( ', ', array_keys( $response_body->contributors ) ) . '</strong><br />';
			$response .= __( 'Plugin Requires:', 'sample-ajax-chicago' ) . ' <strong>' . esc_attr( $response_body->requires ) . '</strong><br />';
			$response .= __( 'Plugin Tested Up To:', 'sample-ajax-chicago' ) . ' <strong>' . esc_attr( $response_body->tested ) . '</strong><br />';
			$response .= __( 'Plugin Rating:', 'sample-ajax-chicago' ) . ' <strong>' . esc_attr( $response_body->rating ) . '</strong><br />';
			$response .= __( 'Plugin # of Ratings:', 'sample-ajax-chicago' ) . ' <strong>' . absint( $response_body->num_ratings ) . '</strong><br />';
			$response .= __( 'Plugin # of Downloads:', 'sample-ajax-chicago' ) . ' <strong>' . number_format( absint( $response_body->downloaded ) ) . '</strong><br />';
			$response .= __( 'Plugin Homepage:', 'sample-ajax-chicago' ) . ' <a href="' . esc_url( $response_body->homepage ) . '"><strong>' . esc_url( $response_body->homepage ) . '</a></strong><br />';
			$response .= __( 'Plugin Download Link:', 'sample-ajax-chicago' ) . ' <a href="' . esc_url( $response_body->download_link ) . '"><strong>' . esc_url( $response_body->download_link ) . '</strong></a><br />';
		$response .= '</p>';

		/** Send the response back to our script and die */
		echo json_encode( $response );
		die;

	}

	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {

		return self::$instance;

	}

}

/** Instantiate the class */
$sample_ajax_chicago = new Sample_Ajax_Chicago;