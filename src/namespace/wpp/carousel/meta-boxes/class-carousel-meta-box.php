<?php namespace WPP\Carousel\Meta_Boxes;
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
 class Carousel_Meta_Box extends \WPP\Carousel\Base\Meta_Box {
	const ID              = 'wpp-carousel-meta-box';
	const TITLE           = 'Carousel Details';
	const PLUGIN_FILE     = WPP_CAROUSEL_PLUGIN_FILE;
	const NONCE_ACTION    = __FILE__;
	const ASSET_VER       = WPP_CAROUSEL_ASSETS_VERSION_NUM;
	const TEXT_DOMAIN     = WPP_CAROUSEL_TEXT_DOMAIN;
	const CONTEXT         = 'normal'; //('normal', 'advanced', or 'side')
	const PRIORITY        = 'core'; //('high', 'core', 'default' or 'low')
	const FORM_PREFIX     = 'wpp_carousel_fields'; // Must be javascript varible name compatable ie no dashes
	const ENQUEUE_SCRIPT  = TRUE;
	const ENQUEUE_STYLE   = TRUE;

	/*
	 *  
	 *  @return void No return value
	 */
	public static function meta_box_display() {
		parent::meta_box_display();
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
	
	/*
	 *  
	 *  @return void No return value
	 */
	public static function save_post( $post_id ) {
		parent::save_post( $post_id );
	}
}