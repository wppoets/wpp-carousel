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
 class Carousel_Slide_Meta_Box extends \WPP\Carousel\Base\Meta_Box {

	/** Used to set the meta-box ID */
	const ID = 'wpp-carousel-slide-meta-box';

	/** Used to store the meta-box title */
	const TITLE = 'Carousel Slides';

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
	const PRIORITY = 'default'; //('high', 'core', 'default' or 'low')

	///** Used to store which callback_args should be sent to the creation of the meta-box */
	//const CALLBACK_ARGS = '';

	///** Used to store the ajax action tag */
	//const AJAX_SUFFIX = ''; // If left empty will use ID

	/** Used to store the form prefex */
	const HTML_FORM_PREFIX = 'wpp_carousel_slide_fields'; // should only use [a-z0-9_]

	/** Used to store the form prefex */
	const HTML_CLASS_PREFIX = 'wpp-carousel-slide-'; // should only use [a-z0-9_-]

	/** Used to store the form prefex */
	const HTML_ID_PREFIX = 'wpp-carousel-slide-'; // should only use [a-z0-9_-]

	/** Used as the metadata key prefix */
	const METADATA_KEY_PREFIX = '_wpp_carousel_slide';

	///** Used to enable ajax callbacks */
	//const ENABLE_AJAX = FALSE;

	/** Used to enable enqueue_media function */
	const ENABLE_ENQUEUE_MEDIA = TRUE;

	/** Used to enable the default scripts */
	const ENABLE_DEFAULT_SCRIPT = TRUE;

	/** Used to enable the default styles */
	const ENABLE_DEFAULT_STYLE = TRUE;

	/** Used to enable the admin footer */
	const ENABLE_ADMIN_FOOTER = TRUE;

	/**
	 * Initialization point for the static class
	 *
	 * @return void No return value
	 */
	static public function init( $options = array() ) {
		parent::init( wpp_array_merge_nested(
			array(
				'data_content_type'   => '',
				'slide_types' => array(),
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
		$empty_message = __( 'Nothing to display, you have no slides.', static::TEXT_DOMAIN );
		$options = parent::get_options();
		$data_content_type = $options['data_content_type'];
		$carousel_slides = array();
		if ( ! empty( $data_content_type ) && class_exists( $data_content_type ) && method_exists( $data_content_type, 'get_posts' ) ) {
			$carousel_slides = $data_content_type::get_posts( array(
				'post_parent' => $post->ID,
			) );
		}
		$carousel_json_data = array();
		foreach ( $carousel_slides as $slide ) {
			if ( empty( $slide->post_content_decoded[ 'slide_type' ] ) 
					|| empty( $options[ 'slide_types' ][ $slide->post_content_decoded[ 'slide_type' ] ] ) ) {
				continue;
			}
			$type_class = $options[ 'slide_types' ][ $slide->post_content_decoded[ 'slide_type' ] ];
			$carousel_json_data[] = $type_class::get_slide_data( $slide );
		}
		?>
			<table id="<?php echo static::HTML_ID_PREFIX; ?>table">
				<thead><tr><th class="<?php echo static::HTML_CLASS_PREFIX; ?>buttons" colspan="4"><button class="<?php echo static::HTML_CLASS_PREFIX; ?>add-slide" type="button"><?php echo __( 'Add Slide', static::TEXT_DOMAIN ); ?></button></th></tr></thead>
				<tbody><tr class="<?php echo static::HTML_CLASS_PREFIX; ?>empty-row"><td class="<?php echo static::HTML_CLASS_PREFIX; ?>empty" colspan="4"><?php echo __( 'Slide data has not finished loading, please be patient...', static::TEXT_DOMAIN ); ?></td></tr></tbody>
				<tfoot><tr><td class="<?php echo static::HTML_CLASS_PREFIX; ?>buttons" colspan="4"><button class="<?php echo static::HTML_CLASS_PREFIX; ?>add-slide" type="button"><?php echo __( 'Add Slide', static::TEXT_DOMAIN ); ?></button></td></tr></tfoot>
			</table>
			<script>
				var wpp_carousel_slides = {
					'post_id'            : <?php echo $post->ID; ?>,
					'next_row'           : 1,
					'visible_slides'     : 0,
					'empty_message'      : '<?php echo $empty_message; ?>',
					'starting_data'      : <?php echo json_encode( $carousel_json_data ); ?>,
					'slide_type'         : {},
					'slide_type_options' : {},
					'slide_types'        : <?php echo json_encode( array_keys( $options[ 'slide_types' ] ) ); ?>,
				};
			</script>
		<?php
	}

	/**
	 * WordPress action for enqueueing admin scripts
	 *
	 * @return void No return value
	 */
	static public function action_admin_enqueue_scripts() {
		wp_register_style( 
			'jquery-ui-1.10.3.mp6', 
			plugins_url( '/styles/' . 'jquery-ui-1.10.3.mp6.css', static::PLUGIN_FILE ), 
			array(), 
			static::ASSET_VER,
			'all'
		);
		wp_enqueue_style( 'jquery-ui-1.10.3.mp6' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		parent::action_admin_enqueue_scripts();
	}
	
	/**
	 * WordPress action for adding things to the admin footer
	 *
	 * @return void No return value
	 */
	static public function action_admin_footer() {
		$options = parent::get_options();
		?>
			<div id="<?php echo self::HTML_ID_PREFIX; ?>confirm-delete-dialog" title="Delete the slide?">
			  <p><span class="dashicons dashicons-sos" style="float:left; margin:0 7px 20px 0;"></span>The slide will be permanently deleted on update and cannot be recovered. Are you sure?</p>
			</div>
			<div id="<?php echo self::HTML_ID_PREFIX; ?>slide-type-dialog" title="Select Slide Type">
				<p class="validateTips">Please pick one from the following.</p>
				<form>
					<fieldset>
					<?php foreach( $options[ 'slide_types' ] as $slide_type => &$slide_class ) : ?>
						<input type="radio" name="slide_type" value="<?php echo $slide_type; ?>"><?php echo ucwords( $slide_type ); ?><br>
					<?php endforeach; ?>
					</fieldset>
				</form>
			</div>
			<script>
			<?php foreach( $options[ 'slide_types' ] as $slide_type => $slide_class ) : ?>
				wpp_carousel_slides.slide_type_options.<?php echo $slide_type; ?> = {
					has_image    : <?php echo ( $slide_class::has_image() ) ? 'true' : 'false' ;?>,
					allow_image_change : <?php echo ( $slide_class::allow_image_change() ) ? 'true' : 'false' ;?>,
				};
				wpp_carousel_slides.slide_type.<?php echo $slide_type; ?> = function( row_id ) {
					var content = '';
					<?php echo $slide_class::get_javascript_form_fields( self::HTML_ID_PREFIX, self::HTML_CLASS_PREFIX, self::HTML_FORM_PREFIX ); ?>

					return content;
				};
			<?php endforeach; ?>
				wpp_carousel_slides.new_row = function( row_id, slide_type ) {
					var image_div = ' <?php echo self::HTML_CLASS_PREFIX; ?>image-not-selected';
					var image_change = '(<a class="<?php echo self::HTML_CLASS_PREFIX; ?>select-image-button" href="#">change</a>)';
					if(wpp_carousel_slides.slide_type_options[ slide_type ]){
						if(wpp_carousel_slides.slide_type_options[ slide_type ].has_image == 'false') {
							image_div = ' <?php echo self::HTML_CLASS_PREFIX; ?>image-not-available';
						}
						if(wpp_carousel_slides.slide_type_options[ slide_type ].allow_image_change == 'false') {
							image_change = '';
						}
					}
					var content = [
						'<tr id="<?php echo self::HTML_ID_PREFIX; ?>row-' + row_id + '" class="<?php echo self::HTML_CLASS_PREFIX; ?>row">',
							'<td class="<?php echo self::HTML_CLASS_PREFIX; ?>colunm-1">',
								'<button type="button" class="button <?php echo self::HTML_CLASS_PREFIX; ?>remove-slide">-</button>',
								'<input class="<?php echo self::HTML_CLASS_PREFIX; ?>field-removed" type="hidden" name="<?php echo self::HTML_FORM_PREFIX; ?>[rows][' + row_id + '][slide_removed]" value="false">',
							'</td>',
							'<td class="<?php echo self::HTML_CLASS_PREFIX; ?>colunm-2">',
								'Image: ' + image_change + '<br />',
								'<div class="<?php echo self::HTML_CLASS_PREFIX; ?>image' + image_div + '"><img class="<?php echo self::HTML_CLASS_PREFIX; ?>field-image-src" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=" width="150" height="150" /></div>',
								'<input class="<?php echo self::HTML_CLASS_PREFIX; ?>field-image-id" type="hidden" name="<?php echo self::HTML_FORM_PREFIX; ?>[rows][' + row_id + '][slide_image_id]" value="false">',
								'<input class="<?php echo self::HTML_CLASS_PREFIX; ?>field-post-id" type="hidden" name="<?php echo self::HTML_FORM_PREFIX; ?>[rows][' + row_id + '][slide_post_id]" value="false">',
							'</td>',
							'<td class="<?php echo self::HTML_CLASS_PREFIX; ?>colunm-3">',
					].join('');
					if ( wpp_carousel_slides.slide_types.indexOf( slide_type ) != -1 ) {
						content = content + wpp_carousel_slides.slide_type[ slide_type ]( row_id );
					}
					content = content + [
							'</td>',
							'<td class="<?php echo self::HTML_CLASS_PREFIX; ?>colunm-4">',
								'<div class="<?php echo self::HTML_CLASS_PREFIX; ?>sort dashicons dashicons-sort"></div>',
								'<input class="<?php echo self::HTML_CLASS_PREFIX; ?>field-type" type="hidden" name="<?php echo self::HTML_FORM_PREFIX; ?>[rows][' + row_id + '][slide_type]" value="' + slide_type + '">',
								'<input type="hidden" name="<?php echo self::HTML_FORM_PREFIX; ?>[sort_order][]" value="' + row_id + '">',
							'</td>',
						'</tr>',
					].join('');
					return content;
				}
			</script>
		<?php
	}

	/**
	 * WordPress action for saving the post
	 * 
	 * @return void No return value
	 */
	static public function action_save_post( $post_id ) {
		parent::action_save_post( $post_id );
		$options = parent::get_options();
		$data_content_type = $options['data_content_type'];
		if ( empty( $data_content_type ) && class_exists( $data_content_type ) && method_exists( $data_content_type, 'save_post' ) && method_exists( $data_content_type, 'delete_post' ) ) {
			return;
		}
		$post_order = -1000; //The default is 0 so just in the off chance we have other posts we want to use our order first
		$form_data = filter_input( INPUT_POST, static::HTML_FORM_PREFIX, FILTER_SANITIZE_STRING, FILTER_FORCE_ARRAY );
		if ( empty( $form_data['sort_order'] ) ) { // If the sort_order is empty no need to keep going
			return;
		}
		$static_instance = get_called_class();
		remove_action( 'save_post', array( $static_instance, 'action_save_post' ) );
		foreach ( (array) $form_data['sort_order'] as $row_id ) {
			if ( empty( $form_data[ 'rows' ][ $row_id ] ) ) { // If the row is empty no need to keep going
				continue;
			}
			$active_row = &$form_data[ 'rows' ][ $row_id ];
			if ( 'false' === $active_row[ 'slide_removed' ] ) { // removed is set to 'false'
				$insert_post_return = $data_content_type::save_post( $active_row, array(
					'post_parent' => $post_id,
					'menu_order'  => $post_order++,
				) );
				unset( $insert_post_return );
			} elseif ( 'true' === $active_row[ 'slide_removed' ] && 'false' !== $active_row[ 'slide_post_id' ] ) { // removed is set to 'true' and post_id is not set to 'false'
				$data_content_type::delete_post( $active_row[ 'slide_post_id' ] );
			}
		}
		add_action( 'save_post', array( $static_instance, 'action_save_post' ) );
		unset( $post_type, $post_order, $form_data, $static_instance );
	}
}