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
defined( 'WPP_CAROUSEL_VERSION_NUM' ) or die(); //If the base plugin is not used we should not be here
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
abstract class Meta_Box {
	const META_BOX_ID          = 'wpp_meta_box';
	const META_BOX_TITLE       = 'WPP Meta Box';
	const META_BOX_TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;
	const META_BOX_NONCE       = __FILE__;

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
		wpp_debug( __METHOD__ . ': $static_instance = ' . $static_instance);
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) { return; }
		self::$_options[ $static_instance ] = array(); //setup the static instance of the class
		self::set_options( $options );
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
	public static function set_options( $options, $overwrite = FALSE ) {
		$static_instance = get_called_class();
		self::$_options[ $static_instance ] = array_merge_recursive(
			array( //Default options
				'post_types' => array(), 
				'all_types' => FALSE ,
			),
			( $overwrite ) ? array() : self::$_options[ $static_instance ], //if ! $overwrite add the current options to the merge
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
		if ( ! empty( self::$_options[ $static_instance ][ 'all_types' ] ) ) {
			self::$_options[ $static_instance ][ 'post_types' ] = get_post_types( 'public', 'names' );
		}
		foreach ( (array) self::$_options[ $static_instance ][ 'post_types' ] as $current_post_type ) {
			add_meta_box(
				static::META_BOX_ID,
				__( static::META_BOX_TITLE, static::META_BOX_TEXT_DOMAIN ),
				array( $static_instance, 'meta_box_display' ),
				$current_post_type
			);
		}
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function meta_box_display() {
		wp_nonce_field( static::META_BOX_NONCE, static::META_BOX_ID . '_wpnonce' );
	}
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function save_post( $post_id ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) { return; } //Check users permissions
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  { return; } //Check skip if we are only auto saving
		if ( wp_is_post_revision( $post_id ) ) { return; } //Check to make sure it is not a revision
		if ( ! wp_verify_nonce( filter_input( INPUT_POST, static::META_BOX_ID . '_wpnonce', FILTER_SANITIZE_STRING ), static::META_BOX_NONCE ) ) { return; } //Verify the form
	}
}