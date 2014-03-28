<?php namespace WPP\Carousel\Meta_Boxes;
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
defined( 'WPP_CAROUSEL_VERSION_NUM' ) or die(); //If the base plugin is not used we should not be here
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
class Carousel_Meta_Box extends \WPP\Carousel\Base\Meta_Box {
 	
	/** Used to set the meta-box ID */
	const ID = 'wpp-carousel-meta-box';

	/** Used to store the meta-box title */
	const TITLE = 'Carousel Details';

	/** Used to store the plugin file location */
	const PLUGIN_FILE = WPP_CAROUSEL_PLUGIN_FILE;

	/** Used to store the asset version */
	const ASSET_VER = WPP_CAROUSEL_ASSETS_VERSION_NUM;

	/** Used to store the text domain */
	const TEXT_DOMAIN = WPP_CAROUSEL_TEXT_DOMAIN;

	/** Used to store the nonce action */
	const NONCE_ACTION = __FILE__;

	///** Used to store which post types to include, comma seperated list */
	//const INCLUDE_POST_TYPES = '';

	///** Used to store which post types to exclude, comma seperated list */
	//const EXCLUDE_POST_TYPES = '';

	///** Used to enable including all post types */
	//const ENABLE_ALL_POST_TYPES = FALSE;

	/** Used to store waht context the meta-box should be located */
	const CONTEXT = 'normal'; //('normal', 'advanced', or 'side')

	/** Used to store what priority the meta-box should have */
	const PRIORITY = 'core'; //('high', 'core', 'default' or 'low')

	///** Used to store which callback_args should be sent to the creation of the meta-box */
	//const CALLBACK_ARGS = '';

	///** Used to store the ajax action tag */
	//const AJAX_SUFFIX = ''; // If left empty will use ID

	/** Used to store the form prefex */
	const HTML_FORM_PREFIX = 'wpp_carousel_fields'; // should only use [a-z0-9_]

	/** Used to store the form prefex */
	const HTML_CLASS_PREFIX = 'wpp-carousel-'; // should only use [a-z0-9_-]

	/** Used to store the form prefex */
	const HTML_ID_PREFIX = 'wpp-carousel-'; // should only use [a-z0-9_-]

	/** Used as the metadata key prefix */
	const METADATA_KEY_PREFIX = '_wpp_carousel_';

	///** Used to enable ajax callbacks */
	//const ENABLE_AJAX = FALSE;

	///** Used to enable enqueue_media function */
	//const ENABLE_ENQUEUE_MEDIA = FALSE;

	/** Used to enable the default scripts */
	const ENABLE_DEFAULT_SCRIPT = TRUE;

	/** Used to enable the default styles */
	const ENABLE_DEFAULT_STYLE  = TRUE;

	///** Used to enable the admin footer */
	//const ENABLE_ADMIN_FOOTER = FALSE;

	/** Used to enable the admin footer */
	const ENABLE_SINGLE_SAVE_POST = TRUE;

	/**
	 * Initialization point for the static class
	 *
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		parent::init( wpp_array_merge_nested(
			array(
				'view_types' => array(),
				'metadata_key_data' => '',
			),
			$options
		) );
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
		parent::action_meta_box_display( $post, $callback_args );
		$options = static::get_options();
		$form_data = array();
		if ( ! empty( $options[ 'metadata_key_data' ] ) ) {
			$form_data = json_decode( get_post_meta( $post->ID, $options[ 'metadata_key_data' ], TRUE ), TRUE );
		}
		$field_counter = 0;
		?>
		<p>
			<input class="<?php echo self::HTML_CLASS_PREFIX; ?>field-view-type" type="hidden" name="<?php echo self::HTML_FORM_PREFIX; ?>[view_type]" value="bootstrap_3">
			<div class="wpp-carousel-field-block">
				<label for="<?php echo static::ID . '-field-id-' . ++$field_counter; ?>">Carousel ID: <em>(must be unique to the page)</em></label><br />
				<input type="text" id="<?php echo static::ID . '-field-id-' . $field_counter; ?>" name="<?php echo static::HTML_FORM_PREFIX; ?>[carousel_id]" value="<?php echo ( empty( $form_data['carousel_id'] ) ? '' : $form_data['carousel_id'] ); ?>" /><br />
			</div>			
			<div class="wpp-carousel-field-block">
				<label for="<?php echo static::ID . '-field-id-' . ++$field_counter; ?>">Carousel Timer: <em>(time in milliseconds)</em></label><br />
				<input type="text" id="<?php echo static::ID . '-field-id-' . $field_counter; ?>" name="<?php echo static::HTML_FORM_PREFIX; ?>[carousel_timer]" value="<?php echo ( empty( $form_data['carousel_timer'] ) ? '5000': $form_data['carousel_timer'] ); ?>" /><br />
			</div>
		</p>
		<p>
			<em>** At this time the only view type available is Bootstrap 3 **</em>
		</p>
		<?php
	}

	/**
	 * WordPress action for saving the post
	 * 
	 * @return void No return value
	 */
	static public function action_save_post( $post_id ) {
		if ( ! parent::action_save_post( $post_id ) ) {
			return;
		}
		$options = static::get_options();
		if ( ! empty( $options[ 'metadata_key_data' ] ) ) {
			$form_data = filter_input( INPUT_POST, static::HTML_FORM_PREFIX, FILTER_SANITIZE_STRING, FILTER_FORCE_ARRAY );
			$form_data_encoded = json_encode( $form_data );
			add_post_meta( $post_id, $options[ 'metadata_key_data' ], $form_data_encoded, TRUE ) || update_post_meta( $post_id, $options[ 'metadata_key_data' ], $form_data_encoded );
			unset( $form_data, $form_data_encoded);
		}
	}

}
