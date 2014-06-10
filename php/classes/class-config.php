<?php namespace WPP\Slideshow;
defined( 'WPP_SLIDESHOW_VERSION_NUM' ) or die(); //If the base plugin is not used we should not be here
/**
 * @author Michael Stutz <michaeljstutz@gmail.com>
 */
class Config extends \WPP\Slideshow\Base\Instance_Config {

	/**
	 * Initialization point for the configuration
	 * 
	 * Because this is used before the overall config you must 
	 * use the $config class directly
	 *
	 * @return void No return value
	 */
	static public function init_config() {
		parent::init_config();
		//Local config
		static::set_config( 'id', 'wpp-slideshow-config' ); // All instances require an id :)
		//Global config
		static::set_config( 'text_domain', WPP_SLIDESHOW_TEXT_DOMAIN, TRUE );
		static::set_config( 'asset_version', WPP_SLIDESHOW_ASSETS_VERSION, TRUE );
		static::set_config( 'base_url', WPP_SLIDESHOW_BASE_URL, TRUE );
		static::set_config( 'base_scripts_url', WPP_SLIDESHOW_BASE_URL_SCRIPTS, TRUE );
		static::set_config( 'base_styles_url', WPP_SLIDESHOW_BASE_URL_STYLES, TRUE );
		static::set_config( 'extension_js', WPP_SLIDESHOW_EXTENTION_SCRIPTS, TRUE );
		static::set_config( 'extension_css', WPP_SLIDESHOW_EXTENTION_STYLES, TRUE );
		static::set_config( 'meta_key_prefix', '', TRUE );
		static::set_config( 'cache_group', WPP_SLIDESHOW_CACHE_GROUP, TRUE );
	}

}
