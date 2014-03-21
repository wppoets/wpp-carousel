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
abstract class Content_Type {
	const CONTENT_TYPE_ID          = 'wpp-content-type';
	const CONTENT_NAME_SINGLE      = 'Content';
	const CONTENT_NAME_PLURAL      = 'Contents';
	const CONTENT_TYPE_TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;

	protected static $_initialized = array();
	protected static $_options = array();

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

		self::$_options[ $static_instance ]    = array(); //setup the static instance of the class

		static::set_options( $options );
		
		register_post_type( static::CONTENT_TYPE_ID, self::$_options[ $static_instance ][ 'args' ] );
		add_action('dashboard_glance_items', array( $static_instance, 'dashboard_glance_items' ) );
		
		static::meta_boxes_init();

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
			array ( 
				'args' => array(
					'labels'             => array(
						'name'               => _x( ucfirst( strtolower( static::CONTENT_NAME_PLURAL ) ), 'post type general name', static::CONTENT_TYPE_TEXT_DOMAIN ),
						'singular_name'      => _x( ucfirst( strtolower( static::CONTENT_NAME_SINGLE ) ), 'post type singular name', static::CONTENT_TYPE_TEXT_DOMAIN ),
						'menu_name'          => _x( ucfirst( strtolower( static::CONTENT_NAME_PLURAL ) ), 'admin menu', static::CONTENT_TYPE_TEXT_DOMAIN ),
						'name_admin_bar'     => _x( ucfirst( strtolower( static::CONTENT_NAME_SINGLE ) ), 'add new on admin bar', static::CONTENT_TYPE_TEXT_DOMAIN ),
						'add_new'            => _x( 'Add New', strtolower( static::CONTENT_NAME_SINGLE ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'add_new_item'       => __( 'Add New ' . ucfirst( strtolower( static::CONTENT_NAME_SINGLE ) ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'new_item'           => __( 'New ' . ucfirst( strtolower( static::CONTENT_NAME_SINGLE ) ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'edit_item'          => __( 'Edit ' . ucfirst( strtolower( static::CONTENT_NAME_SINGLE ) ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'view_item'          => __( 'View ' . ucfirst( strtolower( static::CONTENT_NAME_SINGLE ) ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'all_items'          => __( 'All ' . ucfirst( strtolower( static::CONTENT_NAME_PLURAL ) ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'search_items'       => __( 'Search ' . ucfirst( strtolower( static::CONTENT_NAME_PLURAL ) ), static::CONTENT_TYPE_TEXT_DOMAIN ),
						'parent_item_colon'  => __( 'Parent ' . ucfirst( strtolower( static::CONTENT_NAME_PLURAL ) ) . ':', static::CONTENT_TYPE_TEXT_DOMAIN ),
						'not_found'          => __( 'No ' . strtolower( static::CONTENT_NAME_PLURAL ) . ' found.', static::CONTENT_TYPE_TEXT_DOMAIN ),
						'not_found_in_trash' => __( 'No ' . strtolower( static::CONTENT_NAME_PLURAL ) . ' found in Trash.', static::CONTENT_TYPE_TEXT_DOMAIN ),
					),
					'public'             => true,
					'publicly_queryable' => true,
					'show_ui'            => true,
					'show_in_menu'       => true,
					'query_var'          => true,
					'rewrite'            => array( 'slug' => strtolower( static::CONTENT_NAME_PLURAL ) ),
					'capability_type'    => 'post',
					'has_archive'        => true,
					'hierarchical'       => false,
					'menu_position'      => null,
					'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt'), //, 'comments' ),
				),
				'meta_boxes' => array(),
			),
			( $overwrite ) ? array() : self::$_options[ $static_instance ], //if ! $overwrite add the current options to the merge
			(array) $options //Added options
		);
	}


	
	/*
	 *
	 */
	public static function dashboard_glance_items() {
		$static_instance = get_called_class();
		$labels = &self::$_options[ $static_instance ]['args']['labels'];
		$post_type_info = get_post_type_object( static::CONTENT_TYPE_ID );
		$num_posts = wp_count_posts( static::CONTENT_TYPE_ID );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $labels['singular_name'], $labels['name'], intval( $num_posts->publish ) );
		echo '<li class="page-count ' . $post_type_info->name. '-count"><a href="edit.php?post_type=' . static::CONTENT_TYPE_ID . '">' . $num . ' ' . $text . '</a></li>';
	}
	
	/*
	 *  
	 */
	public static function meta_boxes_init() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'meta_boxes' ] as $meta_box_class ) {
			$meta_box_class::init(
				array(
					'post_types' => static::CONTENT_TYPE_ID,
				)
			);
		}
	}
}