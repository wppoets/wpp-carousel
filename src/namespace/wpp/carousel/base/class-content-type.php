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
abstract class Content_Type {
	const POST_TYPE           = 'wpp-content-type';
	const NAME_SINGLE         = 'Content';
	const NAME_PLURAL         = 'Contents';
	const TEXT_DOMAIN         = '';
	const DESCRIPTION         = '';
	const IS_PUBLIC           = FALSE;
	const EXCLUDE_FROM_SEARCH = TRUE;
	const PUBLICLY_QUERYABLE  = self::IS_PUBLIC;
	const SHOW_UI             = self::IS_PUBLIC;
	const SHOW_IN_NAV_MENUS   = self::IS_PUBLIC;
	const SHOW_IN_MENU        = self::SHOW_UI;
	const SHOW_IN_ADMIN_BAR   = self::SHOW_IN_MENU;
	const MENU_POSITION       = NULL;
	const MENU_ICON           = NULL;
	const CAPABILITY_TYPE     = 'post';
	const MAP_META_CAP        = TRUE;
	const HIERARCHICAL        = FALSE;
	const SUPPORTS            = 'title,editor';
	const TAXONOMIES          = '';
	const HAS_ARCHIVE         = FALSE;
	const PERMALINK_EPMASK    = EP_PERMALINK;
	const QUERY_VAR           = self::POST_TYPE;
	const CAN_EXPORT          = true;
	const SHOW_DASHBOARD      = FALSE;

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
		//wpp_debug( __METHOD__ . ': $static_instance = ' . $static_instance);
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) { return; }
		self::$_options[ $static_instance ]    = array(); //setup the static instance of the class
		static::set_options( $options );
		add_action( 'init', array( $static_instance, 'wp_init' ) );
		if ( static::SHOW_DASHBOARD ) add_action( 'dashboard_glance_items', array( $static_instance, 'dashboard_glance_items' ) );
		if ( is_admin() ) static::meta_boxes_init();
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
		self::$_options[ $static_instance ] = wpp_array_merge_nested(
			array ( 
				'args' => array(
					'labels'             => array(
						'name'               => _x( ucfirst( strtolower( static::NAME_PLURAL ) ), 'post type general name', static::TEXT_DOMAIN ),
						'singular_name'      => _x( ucfirst( strtolower( static::NAME_SINGLE ) ), 'post type singular name', static::TEXT_DOMAIN ),
						'menu_name'          => _x( ucfirst( strtolower( static::NAME_PLURAL ) ), 'admin menu', static::TEXT_DOMAIN ),
						'name_admin_bar'     => _x( ucfirst( strtolower( static::NAME_SINGLE ) ), 'add new on admin bar', static::TEXT_DOMAIN ),
						'add_new'            => _x( 'Add New', strtolower( static::NAME_SINGLE ), static::TEXT_DOMAIN ),
						'add_new_item'       => __( 'Add New ' . ucfirst( strtolower( static::NAME_SINGLE ) ), static::TEXT_DOMAIN ),
						'new_item'           => __( 'New ' . ucfirst( strtolower( static::NAME_SINGLE ) ), static::TEXT_DOMAIN ),
						'edit_item'          => __( 'Edit ' . ucfirst( strtolower( static::NAME_SINGLE ) ), static::TEXT_DOMAIN ),
						'view_item'          => __( 'View ' . ucfirst( strtolower( static::NAME_SINGLE ) ), static::TEXT_DOMAIN ),
						'all_items'          => __( 'All ' . ucfirst( strtolower( static::NAME_PLURAL ) ), static::TEXT_DOMAIN ),
						'search_items'       => __( 'Search ' . ucfirst( strtolower( static::NAME_PLURAL ) ), static::TEXT_DOMAIN ),
						'parent_item_colon'  => __( 'Parent ' . ucfirst( strtolower( static::NAME_PLURAL ) ) . ':', static::TEXT_DOMAIN ),
						'not_found'          => __( 'No ' . strtolower( static::NAME_PLURAL ) . ' found.', static::TEXT_DOMAIN ),
						'not_found_in_trash' => __( 'No ' . strtolower( static::NAME_PLURAL ) . ' found in Trash.', static::TEXT_DOMAIN ),
					),
					'description'         => static::DESCRIPTION,
					'public'              => static::IS_PUBLIC,
					'exclude_from_search' => static::EXCLUDE_FROM_SEARCH,
					'publicly_queryable'  => static::PUBLICLY_QUERYABLE,
					'show_ui'             => static::SHOW_UI,
					'show_in_nav_menus'   => static::SHOW_IN_NAV_MENUS,
					'show_in_menu'        => static::SHOW_IN_MENU,
					'show_in_admin_bar'   => static::SHOW_IN_ADMIN_BAR,
					'menu_position'       => static::MENU_POSITION,
					'menu_icon'           => static::MENU_ICON,
					'capability_type'     => static::CAPABILITY_TYPE,
					'map_meta_cap'        => static::MAP_META_CAP,
					'hierarchical'        => static::HIERARCHICAL,
					'supports'            => explode( ',', static::SUPPORTS ),
					'taxonomies'          => explode( ',', static::TAXONOMIES ),
					'has_archive'         => static::HAS_ARCHIVE,
					'permalink_epmask'    => static::PERMALINK_EPMASK,
					'query_var'           => static::QUERY_VAR,
					'can_export'          => static::CAN_EXPORT,
					'rewrite'             => array( 'slug' => static::POST_TYPE ),
				),
				'meta_boxes' => array(),
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
	 */
	public static function wp_init() {
		$static_instance = get_called_class();
		register_post_type( static::POST_TYPE, self::$_options[ $static_instance ][ 'args' ] );
	}
	
	/*
	 *
	 */
	public static function dashboard_glance_items() {
		$static_instance = get_called_class();
		$labels = &self::$_options[ $static_instance ]['args']['labels'];
		$post_type_info = get_post_type_object( static::POST_TYPE );
		$num_posts = wp_count_posts( static::POST_TYPE );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $labels['singular_name'], $labels['name'], intval( $num_posts->publish ) );
		echo '<li class="page-count ' . $post_type_info->name. '-count"><a href="edit.php?post_type=' . static::POST_TYPE . '">' . $num . ' ' . $text . '</a></li>';
	}
	
	/*
	 *  
	 */
	public static function meta_boxes_init() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'meta_boxes' ] as $meta_box_class ) {
			$meta_box_class::init(
				array(
					'include_post_types' => array( static::POST_TYPE ),
				)
			);
		}
	}
}