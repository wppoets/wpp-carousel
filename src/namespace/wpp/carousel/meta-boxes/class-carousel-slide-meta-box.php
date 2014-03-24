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
 class Carousel_Slide_Meta_Box extends \WPP\Carousel\Base\Meta_Box {
	const ID              = 'wpp-carousel-slide-meta-box';
	const TITLE           = 'Carousel Slides';
	const PLUGIN_FILE     = WPP_CAROUSEL_PLUGIN_FILE;
	const NONCE_ACTION    = __FILE__;
	const ASSET_VER       = WPP_CAROUSEL_ASSETS_VERSION_NUM;
	const TEXT_DOMAIN     = WPP_CAROUSEL_TEXT_DOMAIN;
	const CONTEXT         = 'normal'; //('normal', 'advanced', or 'side')
	const PRIORITY        = 'default'; //('high', 'core', 'default' or 'low')
	const FORM_PREFIX     = 'wpp_carousel_slide_fields'; // Must be javascript varible name compatable ie no dashes
	const METADATA_KEY    = '_wpp_carousel_slide';
	const ENQUEUE_MEDIA   = TRUE;
	const ENQUEUE_SCRIPT  = TRUE;
	const ENQUEUE_STYLE   = TRUE;

	/*
	 *  
	 *  @return void No return value
	 */
	public static function meta_box_display( $post, $callback_args ) {
		parent::meta_box_display();
		$empty_message = __( 'Nothing to display, you have no slides.', static::TEXT_DOMAIN );
		$carousel_slides = array();
		if ( \WPP\Carousel\Content_Types\Carousel_Slide::is_initialized() ) {
			$post_type = \WPP\Carousel\Content_Types\Carousel_Slide::POST_TYPE;
			$carousel_slide_query = new \WP_Query( array( 
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'post_parent'    => $post->ID,
				'order'          => 'ASC',
				'order_by'       => 'menu_order',
				'nopaging'       => TRUE,
				'posts_per_page' => -1,
			) );
			$carousel_slides = ( empty( $carousel_slide_query->posts ) ? array() : $carousel_slide_query->posts );
			wp_reset_postdata();
		} else {
			print('<style>#wpp-carousel-slide-table .wpp-carousel-slide-buttons > button{display:none;}</style>');
			$empty_message = __( 'Error, required content type not initialized.', static::TEXT_DOMAIN );
			trigger_error( __( 'Required content type not initialized, data not saved.', static::TEXT_DOMAIN ), E_USER_NOTICE);
		}
		?>
		<table id="wpp-carousel-slide-table">
			<thead><tr><th class="wpp-carousel-slide-buttons" colspan="4"><button class="wpp-carousel-slide-add-static-slide" type="button"><?php echo __( 'Add Static Slide', static::TEXT_DOMAIN ); ?></button><!-- <button class="wpp-carousel-slide-add-dynamic-slide" type="button"><?php echo __( 'Add Dynamic Slide', static::TEXT_DOMAIN ); ?></button> --></th></tr></thead>
			<tbody><tr class="wpp-carousel-slide-empty-row"><td class="wpp-carousel-slide-empty" colspan="4"><?php echo __( 'Slide data has not finished loading, please be patient...', static::TEXT_DOMAIN ); ?></td></tr></tbody>
			<tfoot><tr><td class="wpp-carousel-slide-buttons" colspan="4"><button class="wpp-carousel-slide-add-static-slide" type="button"><?php echo __( 'Add Static Slide', static::TEXT_DOMAIN ); ?></button><!-- <button class="wpp-carousel-slide-add-dynamic-slide" type="button"><?php echo __( 'Add Dynamic Slide', static::TEXT_DOMAIN ); ?></button> --></td></tr></tfoot>
		</table>
		<script>
			var wpp_carousel_slide_post_id = <?php echo $post->ID; ?>;
			var wpp_carousel_slide_next_row_id = 1;
			var wpp_carousel_slide_visible_slides = 0;
			var wpp_carousel_slide_empty_message = '<?php echo $empty_message; ?>';
			var wpp_carousel_slide_starting_data = [ 
			<?php 
		foreach ( $carousel_slides as $slide ) {
			$starting_data_row = '';
			$fields = json_decode( $slide->post_content, TRUE );
			if ( ! empty( $fields['type'] ) && 'static' === $fields['type'] ) {
				$slide->post_featured_id = get_post_thumbnail_id( $slide->ID );
				$starting_data_row .= "\n\t\t\t\t{";
				$starting_data_row .= "'slide_post_id':'{$slide->ID}',";
				$starting_data_row .= "'slide_type':'static',";
				if ( ! empty( $slide->post_featured_id ) ) {
					$image = wp_get_attachment_image_src( $slide->post_featured_id, 'thumbnail' );
					if ( $image ) {
						list($src, $width, $height) = $image;
						$slide->post_featured_url = $src;
						$starting_data_row .= "'slide_image_id':'{$slide->post_featured_id}',";
						$starting_data_row .= "'slide_image_src':'{$slide->post_featured_url}',";
						unset( $src, $width, $height );
					}
					unset( $image );
				}
				$starting_data_row .= "'slide_title':'{$slide->post_title}',";
				$starting_data_row .= "'slide_title_enabled':" . ( empty( $fields['title_enabled'] ) ? 'false' : $fields['title_enabled'] ) . ",";
				$starting_data_row .= "'slide_link':'" . ( empty( $fields['link'] ) ? '' : $fields['link'] ) . "',";
				$starting_data_row .= "'slide_link_enabled':" . ( empty( $fields['link_enabled'] ) ? 'false' : $fields['link_enabled'] ) . ",";
				$starting_data_row .= "'slide_caption':'{$slide->post_excerpt}',";
				$starting_data_row .= "'slide_caption_enabled':" . ( empty( $fields['caption_enabled'] ) ? 'false' : $fields['caption_enabled'] ) . ",";
				$starting_data_row .= '},';
			}
			print( $starting_data_row );
		}
		?>

			];
		</script>
		<?php
	}

	/*
	 *  
	 *  @return void No return value
	 */
	public static function save_post( $post_id ) {
		parent::save_post( $post_id );
		if ( \WPP\Carousel\Content_Types\Carousel_Slide::is_initialized() ) {
			$post_type = \WPP\Carousel\Content_Types\Carousel_Slide::POST_TYPE;
			$post_order = -1000; //The default is 0 so just in the off chance we have other posts we want to use our order first
			$form_data = filter_input( INPUT_POST, static::FORM_PREFIX, FILTER_SANITIZE_STRING, FILTER_FORCE_ARRAY );
			if ( ! empty( $form_data['sort_order'] ) ) {
				$static_instance = get_called_class();
				remove_action( 'save_post', array( $static_instance, 'save_post' ) );
				foreach ( (array) $form_data['sort_order'] as $row_id ) {
					if ( ! empty( $form_data[ 'rows' ][ $row_id ] ) ) {
						$active_row = &$form_data[ 'rows' ][ $row_id ];
						if ( 'false' === $active_row[ 'removed' ] ) { // removed is set to 'false'
							//Add post
							$insert_post_return = wp_insert_post(
								array(
									'ID'             => ('false' === $active_row[ 'post_id' ] ? NULL : $active_row[ 'post_id' ] ),
									'post_content'   => json_encode( $active_row ),
									'post_name'      => '',
									'post_title'     => wp_strip_all_tags( ( empty( $active_row[ 'title' ] ) ? '' : $active_row[ 'title' ] ) ),
									'post_status'    => 'publish',
									'post_type'      => $post_type,
									'post_parent'    => $post_id,
									'menu_order'     => $post_order++,
									'post_excerpt'   => ( empty( $active_row[ 'caption' ] ) ? '' : $active_row[ 'caption' ] ),
									'comment_status' => 'closed',
								),
								TRUE
							);
							if ( ! is_wp_error( $insert_post_return ) ) {
								if ( 'false' !== $active_row[ 'post_id' ] && ! empty( $active_row[ 'image_id' ] ) && 'false' !== $active_row[ 'image_id' ] ) {
									add_post_meta( $active_row[ 'post_id' ], '_thumbnail_id', $active_row[ 'image_id' ], TRUE ) || update_post_meta( $active_row[ 'post_id' ], '_thumbnail_id', $active_row[ 'image_id' ]);
								}
							}
							unset( $insert_post_return );
						} elseif ( 'true' === $active_row[ 'removed' ] && 'false' !== $active_row[ 'post_id' ] ) { // removed is set to 'true' and post_id is not set to 'false'
							wp_delete_post( $active_row[ 'post_id' ], TRUE );
						}
					}
				}
				add_action( 'save_post', array( $static_instance, 'save_post' ) );
				unset( $static_instance );
			}
			unset( $post_type, $post_order, $form_data );
		} else {
			trigger_error( __( 'Required content type not initialized, data not saved.', static::TEXT_DOMAIN ), E_USER_NOTICE);
		}
	}
}