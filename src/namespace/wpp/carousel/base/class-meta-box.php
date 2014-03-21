<?php namespace WPP\Carousel\Base;
/**
 * Copyright (c) 2014, WP Poets and/or its affiliates <plugins@wppoets.com>
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
	const TEXT_DOMAIN        = '';
	const NONCE_ACTION       = __FILE__;
	const INCLUDE_POST_TYPES = '';
	const EXCLUDE_POST_TYPES = '';
	const ALL_POST_TYPES     = FALSE;

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
				$post_type
			);
		}
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function meta_box_display() {
		wp_nonce_field( static::NONCE_ACTION, static::ID . '-wpnonce' );
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function save_post( $post_id ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) { return; } //Check users permissions
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  { return; } //Check skip if we are only auto saving
		if ( wp_is_post_revision( $post_id ) ) { return; } //Check to make sure it is not a revision
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, static::ID . '-wpnonce', FILTER_SANITIZE_STRING ), static::NONCE_ACTION ) ) { return; } //Verify the form
	}
}