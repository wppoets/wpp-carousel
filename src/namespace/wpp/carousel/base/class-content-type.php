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
 * @version 1.0.0
 */
abstract class Content_Type {

	/** Used to store the post-type id*/
	const POST_TYPE = 'wpp-content-type';

	/** Used to store the singular form of the name */
	const NAME_SINGLE = 'Content';

	/** Used to store the plural form of the name */
	const NAME_PLURAL = 'Contents';

	/** Used to store the text domain */
	const TEXT_DOMAIN = '';

	/** Used by register_post_type args */
	const DESCRIPTION = '';

	/** Used by register_post_type args */
	const IS_PUBLIC = FALSE;

	/** Used by register_post_type args */
	const EXCLUDE_FROM_SEARCH = TRUE;

	/** Used by register_post_type args */
	const PUBLICLY_QUERYABLE = self::IS_PUBLIC;

	/** Used by register_post_type args */
	const SHOW_UI = self::IS_PUBLIC;

	/** Used by register_post_type args */
	const SHOW_IN_NAV_MENUS = self::IS_PUBLIC;

	/** Used by register_post_type args */
	const SHOW_IN_MENU = self::SHOW_UI;

	/** Used by register_post_type args */
	const SHOW_IN_ADMIN_BAR = self::SHOW_IN_MENU;

	/** Used by register_post_type args */
	const MENU_POSITION = NULL;

	/** Used by register_post_type args */
	const MENU_ICON = NULL;

	/** Used by register_post_type args */
	const CAPABILITY_TYPE = 'post';

	/** Used by register_post_type args */
	const MAP_META_CAP = TRUE;

	/** Used by register_post_type args */
	const HIERARCHICAL = FALSE;

	/** Used by register_post_type args, comma delimited */
	const SUPPORTS = 'title,editor';

	/** Used by register_post_type args, comma delimited */
	const TAXONOMIES = '';

	/** Used by register_post_type args */
	const HAS_ARCHIVE = FALSE;

	/** Used by register_post_type args */
	const PERMALINK_EPMASK = EP_PERMALINK;

	/** Used by register_post_type args */
	const QUERY_VAR = self::POST_TYPE;

	/** Used by register_post_type args */
	const CAN_EXPORT = TRUE;

	/** Used by register_post_type args */
	const SHOW_DASHBOARD = FALSE;

	/** Used to disable the quick edit box */
	const DISABLE_QUICK_EDIT = FALSE;

	/** Used to enable cascade delete */
	const ENABLE_CASCADE_DELETE = FALSE;

	/** Used to store the initialization of the class */
	static private $_initialized = array();

	/** Used to store the options */
	static private $_options = array();

	/**
	 * Initialization point for the static class
	 * 
	 * @param string|array $options An optional array containing the meta box options
	 *
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		$static_instance = get_called_class();
		if ( ! empty( self::$_initialized[ $static_instance ] ) ) {
			return;
		}
		static::set_options( $options );
		add_action( 'init', array( $static_instance, 'action_init' ) );
		if ( static::SHOW_DASHBOARD ) {
			add_action( 'dashboard_glance_items', array( $static_instance, 'action_dashboard_glance_items' ) );
		}
		if ( static::DISABLE_QUICK_EDIT ) {
			if ( 'post' === static::CAPABILITY_TYPE ) {
				add_action( 'post_row_actions', array( $static_instance, 'action_post_row_actions_disable_quick_edit' ), 10, 2 );
			} elseif( 'page' === static::CAPABILITY_TYPE ) {
				add_action( 'page_row_actions', array( $static_instance, 'action_post_row_actions_disable_quick_edit' ), 10, 2 );
			}
		}
		if ( static::ENABLE_CASCADE_DELETE ) {
			add_action( 'delete_post', array( $static_instance, 'action_delete_post_cascade' ) );
		}
		if ( is_admin() ) {
			static::init_meta_boxes();
		}
		self::$_initialized[ $static_instance ] = true;
	}
	
	/**
	 * Init method for the meta boxes
	 * 
	 * @return void No return value
	 */
	static public function init_meta_boxes() {
		$static_instance = get_called_class();
		foreach ( (array) self::$_options[ $static_instance ][ 'meta_boxes' ] as $class ) {
			if ( class_exists( $class ) && method_exists( $class, 'init' ) ) {
				$class::init( array(
					'include_post_types' => array( static::POST_TYPE ),
				) );
			}
		}
	}

	/**
	 * Method to find the current initialized value of the instance
	 * 
	 * @return boolean Returns the initialized value of the instance
	 */
	static public function is_initialized() {
		$static_instance = get_called_class();
		return ( empty( self::$_initialized[ $static_instance ] ) ? FALSE : TRUE );
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
	 * WordPress action method for processing cascade delete of a post
	 * 
	 * @param int $post_id Returns the post id of the post being deleted
	 *
	 * @return string Returns the results of the shortcode
	 */
	static public function action_delete_post_cascade( $post_id ) {
		if ( ! static::ENABLE_CASCADE_DELETE || static::POST_TYPE !== get_post_type( $post_id ) ) {
			return;
		}
		$cascade_posts = new \WP_Query( array(
			'post_type'      => get_post_types( array(), 'names' ), // Need to use get_post_types because 'any' doesnt work as expected
			'post_parent'    => $post_id,
			'post_status'    => 'any',
			'nopaging'       => TRUE,
			'posts_per_page' => -1,
			'fields'         => 'ids',
		) );
		$cascade_post_ids = ( empty( $cascade_posts->posts ) ? array() : $cascade_posts->posts );
		foreach ( (array) $cascade_post_ids as $cascade_post_id ) {
			wp_delete_post( $cascade_post_id, TRUE );
		}
	}

	/*
	 * WordPress action method for removing the quick edit option from the page listing
	 *
	 * ref: https://core.trac.wordpress.org/ticket/19343 
	 * If the ever fix it ( I agree its a hack and should be supported in the register post type to disable)
	 *
	 * @param array $actions Array of actions??
	 * @param object $post Post object
	 * @return array Updated actions array
	 */
	static public function action_post_row_actions_disable_quick_edit( $actions, $post ) {
		if ( static::POST_TYPE == $post->post_type ) {
			unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
	}

	/**
	 * WordPress action method for the primary wordpress init
	 *  
	 * @return void No return value
	 */
	static public function action_init() {
		$static_instance = get_called_class();
		register_post_type( static::POST_TYPE, self::$_options[ $static_instance ][ 'args' ] );
	}
	
	/**
	 * WordPress action method for the dashboard glance items
	 *  
	 * @return void No return value
	 */
	static public function action_dashboard_glance_items() {
		$static_instance = get_called_class();
		$labels = &self::$_options[ $static_instance ]['args']['labels'];
		$post_type_info = get_post_type_object( static::POST_TYPE );
		$num_posts = wp_count_posts( static::POST_TYPE );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $labels['singular_name'], $labels['name'], intval( $num_posts->publish ) );
		print( '<li class="page-count ' . $post_type_info->name. '-count"><a href="edit.php?post_type=' . static::POST_TYPE . '">' . $num . ' ' . $text . '</a></li>' );
	}

}