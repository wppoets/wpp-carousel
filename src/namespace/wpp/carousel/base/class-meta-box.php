<?php namespace WPP\Carousel\Base;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <opensource@wppoets.com>
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
 */
abstract class Meta_Box {
	const ID                 = 'wpp-meta-box';
	const TITLE              = 'WPP Meta Box';
	const PLUGIN_FILE        = __FILE__;
	const ASSET_VER          = FALSE;
	const TEXT_DOMAIN        = '';
	const NONCE_ACTION       = __FILE__;
	const INCLUDE_POST_TYPES = '';
	const EXCLUDE_POST_TYPES = '';
	const ALL_POST_TYPES     = FALSE;
	const CONTEXT            = 'advanced'; //('normal', 'advanced', or 'side')
	const PRIORITY           = 'default'; //('high', 'core', 'default' or 'low')
	const CALLBACK_ARGS      = '';
	const ENABLE_AJAX        = FALSE;
	const AJAX_ACTION        = 'wp_ajax_wpp-meta-box'; //Must start with 'wp_ajax_' to work
	const FORM_PREFIX        = 'wpp_meta_box_'; // Must be javascript varible name compatable ie no dashes
	const ENQUEUE_MEDIA      = FALSE;
	const ENQUEUE_SCRIPT     = FALSE;
	const ENQUEUE_STYLE      = FALSE;

	private static $_initialized = false;
	private static $_options = array();
	
	/**
	 * Initialization point for the static class
	 * 
	 * @param string|array $options An optional array containing the meta box options
	 *
	 * @return void No return value
	 */
	public static function init( $options = array() ) {
		$static_instance = get_called_class();
		static::set_options( $options, TRUE ); //No mater if the init as been run before we want to set the options with merge on
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) { return; }
		add_action( 'add_meta_boxes', array( $static_instance, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $static_instance, 'save_post' ) );
		if( static::ENABLE_AJAX ) add_action( static::AJAX_ACTION, array( $static_instance, 'wp_ajax' ) );
		self::$_initialized[ $static_instance ] = true;
	}
	
	/**
	 * set function for the options
	 *  
	 * @param string|array $options An array containing the meta box options
	 * 
	 * @return void No return value
	 */
	public static function set_options( $options, $merge = FALSE ) {
		$static_instance = get_called_class();
		if ( empty( self::$_options[ $static_instance ] ) ) self::$_options[ $static_instance ] = array(); //setup an empty instance if empty
		self::$_options[ $static_instance ] = wpp_array_merge_nested(
			array( //Default options
				'include_post_types' => explode( ',', static::INCLUDE_POST_TYPES ),
				'exclude_post_types' => explode( ',', static::EXCLUDE_POST_TYPES ),
				'all_post_types' => static::ALL_POST_TYPES,
				'context' => static::CONTEXT,
				'priority' => static::PRIORITY,
				'callback_args' => explode( ',', static::CALLBACK_ARGS ),
				'enqueue_meida' => static::ENQUEUE_MEDIA,
			),
			( $merge ) ? self::$_options[ $static_instance ] : array(), //if merge, merge the excisting values
			(array) $options //Added options
		);
	}

	/*
	 * get function for the option array
	 *  
	 * @return array Returns the option array
	 */
	public static function get_options() {
		$static_instance = get_called_class();
		return self::$_options[ $static_instance ];
	}

	/*
	 *  
	 *  @return void No return value
	 */
	public static function add_meta_boxes() {
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
				array( $static_instance, 'meta_box_display' ),
				$post_type,
				$options['context'],
				$options['priority'],
				$options['callback_args']
			);
			add_action( 'add_meta_boxes_' . $post_type, array( $static_instance, 'add_meta_boxes_content_type' ) );
		}
	}

	/*
	 *  
	 *  @return void No return value
	 */
	public static function add_meta_boxes_content_type() {
		$static_instance = get_called_class();
		if ( self::$_options[ $static_instance ][ 'enqueue_meida' ] ) { wp_enqueue_media(); }
		add_action( 'admin_enqueue_scripts', array( $static_instance, 'admin_enqueue_scripts' ) );
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function admin_enqueue_scripts() {
		if ( static::ENQUEUE_STYLE ) {
			wp_register_style( 
				static::ID . '-style', 
				plugins_url( '/styles/' . static::ID . '.css', static::PLUGIN_FILE ), 
				array(), 
				static::ASSET_VER,
				'all'
			);
			wp_enqueue_style( static::ID . '-style' );
		}
		if ( static::ENQUEUE_SCRIPT ) {
			wp_register_script( 
				static::ID . '-script', 
				plugins_url( '/scripts/' . static::ID . '.js', static::PLUGIN_FILE ), 
				array( 'jquery' ), //We are just going to assume we will always need jquery! :P
				static::ASSET_VER
			);
			wp_enqueue_script( static::ID . '-script' );
		}
	}

	/*
	 *  
	 *  @return void No return value
	 */
	public static function wp_ajax( $return_value = array( 'status' => 'success' ) ) {
		print( json_encode( $return_value ) );
		die();
	}

	/*
	 *  
	 *  @return void No return value
	 */
	public static function meta_box_display() {
		wp_nonce_field( static::NONCE_ACTION, static::FORM_PREFIX . '_wpnonce' );
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function save_post( $post_id ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) { return; } //Check users permissions
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  { return; } //Check skip if we are only auto saving
		if ( wp_is_post_revision( $post_id ) ) { return; } //Check to make sure it is not a revision
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, static::FORM_PREFIX . '_wpnonce', FILTER_SANITIZE_STRING ), static::NONCE_ACTION ) ) { return; } //Verify the form
	}

}