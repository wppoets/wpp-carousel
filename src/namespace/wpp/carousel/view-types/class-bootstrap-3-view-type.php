<?php namespace WPP\Carousel\View_Types;
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
class Bootstrap_3_View_Type extends Base_View_Type {
	static public function get_carousel_view( $options = array() ) {
		$carousel_view = '';
		$carousel_view .= static::get_carousel_start( $options );
		$carousel_view .= static::get_indicators( $options );
		if ( ! empty( $options['slides'] ) ) {
			$carousel_view .= static::get_items_start( $options );
			foreach ( $options['slides'] as $slide_key => &$slide ) {
				if ( empty( $slide['image'] ) ) {
					continue;
				}
				$carousel_view .= static::get_item_start( $options, ($slide_key === 0 ? TRUE : FALSE ) );
				$carousel_view .= static::get_item( $slide, $options );
				$carousel_view .= static::get_item_stop( $options );
			}
			$carousel_view .= static::get_items_stop( $options );
		}
		$carousel_view .= static::get_controls( $options );
		$carousel_view .= static::get_carousel_stop( $options );
		$carousel_view .= static::get_carousel_script( $options );
		return $carousel_view;
	}
	static public function get_carousel_start( &$options ) {
		if ( empty( $options['carousel_id'] ) ) {
			$options['carousel_id'] = 'carousel-' . date('YmdHis');
		}
		if ( empty( $options['carousel_class'] ) ) {
			$options['carousel_class'] = '';
		} else {
			$options['carousel_class'] = ' ' . ltrim( $options['carousel_class'] );
		}
		return '<div id="#' . $options['carousel_id'] . '" class="carousel slide' . $options['carousel_class'] . '" data-ride="carousel">';
	}
	static public function get_indicators( &$options ) {
		$return_string = '';
		if ( empty( $options['show_indicators'] ) || empty( $options['slides'] ) ) {
			return $return_string;
		}
		$slide_counter = 1;
		$return_string .= '<ol class="carousel-indicators">';
		foreach ( $options['slides'] as &$slide ) {
			if ( $slide_counter != 1 ) {
				$return_string .= '<li data-target="#' . $options['carousel_id'] . '" data-slide-to="' . $slide_counter . '"></li>';
				$slide_counter++;
			} else {
				$return_string .= '<li data-target="#' . $options['carousel_id'] . '" data-slide-to="' . $slide_counter . '" class="active"></li>';
				$slide_counter++;
			}
		}
		$return_string .= '</ol>';
		return $return_string;
	}
	static public function get_items_start( &$options ) {
		return '<div class="carousel-inner">';
	}
	static public function get_item_start( &$options, $active = FALSE ) {
		return '<div class="item' . ( $active  ? ' active' : '' ) . '">';
	}
	static public function get_item( &$slide, &$options ) {
		$return_string = '';
		if ( empty( $slide['image'] ) ) {
			return $return_string;
		}
		$return_string .= '<img src="' . $slide['image'] . '">';
		if ( ! empty( $slide['title'] ) || ! empty( $slide['caption'] ) ) {
			$return_string .= '<div class="carousel-caption">';
			if ( ! empty( $slide['title'] ) && ! empty( $slide['link'] ) ) {
				if ( substr( $slide['link'], 0, strlen( 'http://' ) ) !== 'http://' ) {
					$slide['link'] = 'http://' . $slide['link'];
				}
				$return_string .= '<h3><a href="' . $slide['link'] . '">' . $slide['title'] . '</a></h3>';
			} else if ( ! empty( $slide['title'] ) ) {
				$return_string .= '<h3>' . $slide['title'] . '</h3>';
			}
			if ( ! empty( $slide['caption'] ) ) {
				$return_string .= '<p>' . $slide['caption'] . '</p>';
			}
			$return_string .= '</div>';
		}
		return $return_string;
	}
	static public function get_item_stop( &$options ) {
		return '</div>';
	}
	static public function get_items_stop( &$options ) {
		return '</div>';
	}
	static public function get_controls( &$options ) {
		$return_string = '';
		if ( empty( $options['show_controls'] ) ) {
			return $return_string;
		}
		$return_string .= '<a class="left carousel-control" href="#' . $options['carousel_id'] . '" data-slide="prev">';
		$return_string .= '<span class="glyphicon glyphicon-chevron-left"></span>';
		$return_string .= '</a>';
		$return_string .= '<a class="right carousel-control" href="#' . $options['carousel_id'] . '" data-slide="next">';
		$return_string .= '<span class="glyphicon glyphicon-chevron-right"></span>';
		$return_string .= '</a>';
		return $return_string;
	}
	static public function get_carousel_stop( &$options ) {
		return '</div>';
	}
	static public function get_carousel_script( &$options ) {
		$return_string = '';
		$return_string .= '<script>';
			$return_string .= '+function ($) {';
				$return_string .= '$(document).ready(function() {';
					$return_string .= '$("#' . $options['carousel_id'] . '").carousel({';
						$return_string .= 'interval: 5000,';
					$return_string .= '});';
				$return_string .= '});';
			$return_string .= '}(jQuery);';
		$return_string .= '</script>';
		$return_string .= '';
		return $return_string;
	}

				
}
