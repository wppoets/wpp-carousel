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
	const FORM_PREFIX = 'wpp_carousel_fields'; // should only use [a-z0-9_]

	/** Used as the metadata key prefix */
	const METADATA_KEY_PREFIX = '_wpp_carousel';

	///** Used to enable ajax callbacks */
	//const ENABLE_AJAX = FALSE;

	///** Used to enable enqueue_media function */
	//const ENABLE_ENQUEUE_MEDIA = FALSE;

	/** Used to enable the default scripts */
	const ENABLE_DEFAULT_SCRIPT = TRUE;

	/** Used to enable the default styles */
	const ENABLE_DEFAULT_STYLE  = TRUE;

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
		$field_counter = 0;
		?>
		<p>
			<div class="wpp-carousel-field-block">
				<h4>Template Backend:</h4>
				<input type="radio" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID; ?>_options['backend']" value="bootstrap_3" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Bootstrap 3 <em>(you must make sure the bootstrap css and js are loaded or things will not work)</em></label><br />
			</div>
			<div class="wpp-carousel-field-block">
				<h4>Display As:</h4>
				<input type="radio" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID; ?>_options['display']" value="i" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Individual Slides <em>(this options will display only one slide at a time)</em></label><br />
				<input type="radio" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID . '_options'; ?>['display']" value="m" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Multiple Slides <em>(this options will display multiple slides at a time)</em></label><br />
			</div>
			<div class="wpp-carousel-field-block">
				<h4>Container Specifications:</h4>
				<input type="textbox" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID; ?>_options['container_width']" value="" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Width <em>(number value in pixels, percent, or empty for auto)</em></label><br />
				<input type="textbox" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID . '_options'; ?>['container_height']" value="" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Height <em>(number value in pixels, percent, or empty for auto)</em></label><br />
			</div>
			<div class="wpp-carousel-field-block">
				<h4>Slide Specifications:</h4>
				<input type="textbox" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID; ?>_options['slide_width']" value="" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Width <em>(number value in pixels, percent, or empty for auto)</em></label><br />
				<input type="textbox" id="<?php echo static::ID . '-field-' . ++$field_counter; ?>" name="<?php echo static::ID . '_options'; ?>['slide_height']" value="" />
				<label for="<?php echo static::ID . '-field-' . $field_counter; ?>">Height <em>(number value in pixels, percent, or empty for auto)</em></label><br />
			</div>
		</p>
		<?php
	}

	/**
	 * WordPress action for saving the post
	 * 
	 * @return void No return value
	 */
	static public function action_save_post( $post_id ) {
		parent::action_save_post( $post_id );
	}

}
