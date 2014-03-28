<?php namespace WPP\Carousel\Base;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <copyright@wppoets.com>
 * All rights reserved.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 * @version 1.0.4
 */
abstract class Meta_Box {

	/** Used to set the meta-box ID */
	const ID = 'wpp-meta-box';

	/** Used to store the meta-box title */
	const TITLE = 'WPP Meta Box';

	/** Used to store the plugin file location */
	const PLUGIN_FILE = __FILE__;

	/** Used to store the asset version */
	const ASSET_VER = FALSE;

	/** Used to store the text domain */
	const TEXT_DOMAIN = '';

	/** Used to store the nonce action */
	const NONCE_ACTION = __FILE__;

	/** Used to store which post types to include, comma seperated list */
	const INCLUDE_POST_TYPES = '';

	/** Used to store which post types to exclude, comma seperated list */
	const EXCLUDE_POST_TYPES = '';

	/** Used to enable including all post types */
	const ENABLE_ALL_POST_TYPES = FALSE;

	/** Used to store waht context the meta-box should be located */
	const CONTEXT = 'advanced'; //('normal', 'advanced', or 'side')

	/** Used to store what priority the meta-box should have */
	const PRIORITY = 'default'; //('high', 'core', 'default' or 'low')

	/** Used to store which callback_args should be sent to the creation of the meta-box */
	const CALLBACK_ARGS = '';

	/** Used to store the ajax action tag */
	const AJAX_SUFFIX = ''; // If left empty will use ID

	/** Used to store the form prefex */
	const HTML_FORM_PREFIX = 'wpp_meta_box'; // should only use [a-z0-9_]

	/** Used to store the form prefex */
	const HTML_CLASS_PREFIX = 'wpp-meta-box-'; // should only use [a-z0-9_-]

	/** Used to store the form prefex */
	const HTML_ID_PREFIX = 'wpp-meta-box-'; // should only use [a-z0-9_-]

	/** Used as the metadata key prefix */
	const METADATA_KEY_PREFIX = '_wpp_meta_box_';

	/** Used to enable ajax callbacks */
	const ENABLE_AJAX = FALSE;

	/** Used to enable enqueue_media function */
	const ENABLE_ENQUEUE_MEDIA = FALSE;

	/** Used to enable the default scripts */
	const ENABLE_DEFAULT_SCRIPT = FALSE;

	/** Used to enable the default styles */
	const ENABLE_DEFAULT_STYLE = FALSE;

	/** Used to enable the admin footer */
	const ENABLE_ADMIN_FOOTER = FALSE;

	/** Used to enable the admin footer */
	const ENABLE_SINGLE_SAVE_POST = FALSE;

	/** Used to store the initialization of the class */
	static private $_initialized = array();

	/** Used to store the options */
	static private $_options = array();

	/** Used to store if save_post has run before */
	static private $_save_post = array();
	
	/**
	 * Initialization point for the static class
	 * 
	 * @param string|array $options An optional array containing the meta box options
	 *
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		$static_instance = get_called_class();
		static::set_options( $options, TRUE ); //No mater if the init as been run before we want to set the options with merge on
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) { 
			return; 
		}
		add_action( 'add_meta_boxes', array( $static_instance, 'action_add_meta_boxes' ) );
		add_action( 'save_post', array( $static_instance, 'action_save_post' ) );
		if ( static::ENABLE_AJAX ) {
			$action_hook = 'wp_ajax_' . static::AJAX_SUFFIX;
			if ( 'wp_ajax_' === $action_hook ) { // Backwards way to check to see if static::AJAX_SUFFIX is empty
				$action_hook .= static::ID;
			}
			add_action( $action_hook, array( $static_instance, 'action_wp_ajax' ) );
			unset( $action_hook );
		}
		self::$_initialized[ $static_instance ] = TRUE;
	}

	/**
	 * Set method for the options
	 *  
	 * @param string|array $options An array containing the meta box options
	 * @param boolean $merge Should the current options be merged in?
	 * 
	 * @return void No return value
	 */
	static public function set_options( $options, $merge = FALSE ) {
		$static_instance = get_called_class();
		if ( empty( self::$_options[ $static_instance ] ) ) {
			self::$_options[ $static_instance ] = array(); //setup an empty instance if empty
		}
		self::$_options[ $static_instance ] = wpp_array_merge_nested(
			array( //Default options
				'include_post_types' => static::INCLUDE_POST_TYPES == '' ? array() : explode( ',', static::INCLUDE_POST_TYPES),
				'exclude_post_types' => static::EXCLUDE_POST_TYPES == '' ? array() : explode( ',', static::EXCLUDE_POST_TYPES),
				'all_post_types' => static::ENABLE_ALL_POST_TYPES,
				'context' => static::CONTEXT,
				'priority' => static::PRIORITY,
				'callback_args' => static::CALLBACK_ARGS == '' ? array() : explode( ',', static::CALLBACK_ARGS, -1 ),
			),
			( $merge ) ? self::$_options[ $static_instance ] : array(), //if merge, merge the excisting values
			(array) $options //Added options
		);
	}

	/**
	 * Get method for the option array
	 *  
	 * @return array Returns the option array
	 */
	static public function get_options() {
		$static_instance = get_called_class();
		return self::$_options[ $static_instance ];
	}

	/**
	 * WordPress action for adding meta boxes
	 * 
	 * @return void No return value
	 */
	static public function action_add_meta_boxes() {
		$static_instance = get_called_class();
		$options = &self::$_options[ $static_instance ];
		$post_types = array();
		if ( ! empty( $options[ 'all_post_types' ] ) ) {
			$post_types = get_post_types( 'public', 'names' );
		} else { 
			$post_types = $options[ 'include_post_types' ];
		}
		$post_types = array_unique( $post_types );
		foreach( $options[ 'exclude_post_types' ] as $exclude_post_type ) {
			$matched_key = array_search( $exclude_post_type, $post_types );
			if( ! empty( $matched_key ) ) {
				unset( $post_types[ $matched_key] ); //Remove the excluded post type
			}
		}
		foreach ( $post_types as $post_type ) {
			add_meta_box(
				static::ID,
				__( static::TITLE, static::TEXT_DOMAIN ),
				array( $static_instance, 'action_meta_box_display' ),
				$post_type,
				$options['context'],
				$options['priority'],
				$options['callback_args']
			);
			add_action( "add_meta_boxes_{$post_type}", array( $static_instance, 'action_add_meta_boxes_content_type' ) );
		}
	}

	/**
	 * WordPress action for adding a meta-box to a specific content type
	 * 
	 * We use this to only enqueue scripts/styles for pages that are going
	 * to display the meta-box 
	 *
	 * @return void No return value
	 */
	static public function action_add_meta_boxes_content_type() {
		$static_instance = get_called_class();
		if ( static::ENABLE_ENQUEUE_MEDIA ) { 
			wp_enqueue_media(); 
		}
		add_action( 'admin_enqueue_scripts', array( $static_instance, 'action_admin_enqueue_scripts' ) );
		if ( static::ENABLE_ADMIN_FOOTER ) {
			add_action( 'admin_footer', array( $static_instance, 'action_admin_footer' ) );
		}
	}

	/**
	 * WordPress action for enqueueing admin scripts
	 *
	 * @return void No return value
	 */
	static public function action_admin_enqueue_scripts() {
		if ( static::ENABLE_DEFAULT_STYLE ) {
			wp_register_style( 
				static::ID . '-style', 
				plugins_url( '/styles/' . static::ID . '.css', static::PLUGIN_FILE ), 
				array(), 
				static::ASSET_VER,
				'all'
			);
			wp_enqueue_style( static::ID . '-style' );
		}
		if ( static::ENABLE_DEFAULT_SCRIPT ) {
			wp_register_script( 
				static::ID . '-script', 
				plugins_url( '/scripts/' . static::ID . '.js', static::PLUGIN_FILE ), 
				array( 'jquery' ), //We are just going to assume we will always need jquery! :P
				static::ASSET_VER
			);
			wp_enqueue_script( static::ID . '-script' );
		}
	}

	/**
	 * WordPress action for adding things to the admin footer
	 *
	 * @return void No return value
	 */
	static public function action_admin_footer() {
		//Print somthing in the admin footer section
	}

	/**
	 * WordPress action for displaying the meta-box
	 *
	 * @param object $post The post object the metabox is working with
	 * @param array $callback_args Extra call back args
	 *
	 * @return void No return value
	 */
	static public function action_meta_box_display( $post, $callback_args ) {
		wp_nonce_field( static::NONCE_ACTION, static::HTML_FORM_PREFIX . '_wpnonce' );
	}

	/**
	 * WordPress action for saving the post
	 * 
	 * @return void No return value
	 */
	static public function action_save_post( $post_id ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {  // Check user can edit
			return; 
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  {  // Check if is auto saving
			return; 
		}
		if ( wp_is_post_revision( $post_id ) ) {  // Check if is revision
			return; 
		}
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, static::HTML_FORM_PREFIX . '_wpnonce', FILTER_SANITIZE_STRING ), static::NONCE_ACTION ) ) {  // Verify wpnonce
			return; 
		}
		if ( static::ENABLE_SINGLE_SAVE_POST ) {
			$static_instance = get_called_class();
			if ( ! empty( self::$_save_post[ $static_instance ] ) ) { 
				return; 
			}
			self::$_save_post[ $static_instance ] = TRUE;
		}
		return TRUE;

		// Example usage
		//if ( ! parent::action_save_post( $post_id ) ) {
		//	return;
		//}
	}

	/**
	 * WordPress action for an ajax call
	 * 
	 * @return void No return value
	 */
	static public function action_wp_ajax() {
		// Example use...
		$return_data = array();
		print( json_encode( $return_data ) );
		die(); //The recomended method after processing the request
	}

}
