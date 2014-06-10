<?php namespace WPP\Slideshow;
defined( 'WPP_SLIDESHOW_VERSION_NUM' ) or die(); //If the base plugin is not used we should not be here
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
class Plugin extends \WPP\Slideshow\Base\Plugin {

	/**
	 * Initialization point for the configuration
	 * 
	 * @return void No return value
	 */
	static public function init_config() {
		static::set_config_instance( Config::init() ); //Required before pretty much anything!
		parent::init_config();
		static::set_config( 'id', 'wpp-slideshow' );
		static::set_config( 'option_key', '' );
		static::set_config( 'option_autoload', FALSE );
		static::set_config( 'enable_admin_controllers', FALSE );
		static::set_config( 'enable_admin_pages', FALSE );
		static::set_config( 'enable_content_types', FALSE );
		static::set_config( 'enable_meta_boxes', FALSE );
		static::set_config( 'enable_shortcodes', FALSE );
	}

}
