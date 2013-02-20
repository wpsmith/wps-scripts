<?php

/**
 * Plugin Name: WP Font Awesome
 * Plugin URI: http://wpsmith.net
 * Description: Use the Font Awesome icon set within WordPress. Icons can be inserted using either HTML or a shortcode.
 * Version: 3.0.1
 * Author: Travis Smith
 * Author URI: http://wpsmith.net
 *
 * License:
 * Copyright (C) 2012  Travis Smith
 * 
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 * 
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


/**
 * Font Awesome Class
 * Version: 3.0.0
 *
 */
class WP_Font_Awesome extends WPS_Scripts {
	
	/**
     * Hooks plugin into all basic
     * 
     * @todo Updater doesn't need to run on every admin page
     */
    public function plugins_loaded() {
		
		// Updater
		add_action( 'admin_init', array( $this, 'updater' ) );
		
		// Register Styles
        add_action( 'init', array( $this, 'register_styles' ) );
        
		// Enqueue Styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		
		// Add Shortcodes
		add_shortcode( 'icon', array( $this, 'shortcode' ) );
		
		// Add shortcode to widgets
        add_filter( 'widget_text', 'do_shortcode' );
        
    }

	/**
     * Updater
     * 
     */
	function updater() {

		include_once 'updater/updater.php';

		define( 'WP_GITHUB_FORCE_UPDATE', true );
		$plugin = 'wpsmith/WP-Font-Awesome';
		$config = array(
			'slug'               => plugin_basename( __FILE__ ),
			'proper_folder_name' => 'WP-Font-Awesome',
			'api_url'            => sprintf( 'https://api.github.com/repos/%s', $plugin ),
			'raw_url'            => sprintf( 'https://raw.github.com/%s/master/build', $plugin ),
			'readme_raw_url'     => sprintf( 'https://raw.github.com/%s/master', $plugin ),
			'github_url'         => sprintf( 'https://github.com/%s', $plugin ),
			'zip_url'            => sprintf( 'https://github.com/%s/blob/master/build/wp-font-awesome.zip?raw=true', $plugin ),
			'sslverify'          => false,
			'requires'           => '3.0',
			'tested'             => '3.5.2',
			'readme'             => 'README.md',
			'access_token'       => '',
		);

		$_wp_github_updater = new WP_GitHub_Updater( $config );

	}
	
	/**
      * Get all Font Awesome classes
      * 
      * WP_Font_Awesome::get_font_classes()
      * 
	  * @uses get_font_classes_raw() Get raw list of Font Awesome classes
      * @return array $icons Alpha sorted list of available Font Awesome classes
      */
	static function get_font_classes() {
		$classes = WP_Font_Awesome::get_font_classes_raw();
		foreach ( $classes as $key => $class )
			$classes[ $class ] = 'icon-' . $class;

		return $classes;
	}
	
	/**
      * Get all Font Awesome classes as Names
      * 
      * WP_Font_Awesome::get_font_class_names()
      * 
      * @uses get_font_classes_raw() Get raw list of Font Awesome classes
      * @return array $icons Alpha sorted list of available Font Awesome classes
      */
	static function get_font_class_names() {
		$classes = WP_Font_Awesome::get_font_classes_raw();
		foreach ( $classes as $key => $class )
			 $classes[ $class ] = ucwords( str_replace( '-', ' ', $class ) );

		return $classes;
	}
	
	/**
      * Get all Font Awesome classes raw
      * 
      * WP_Font_Awesome::get_font_classes_raw()
      * 
      * @return array $icons Alpha sorted list of available Font Awesome classes
      */
	static function get_font_classes_raw() {
		$icons = array(
		// Font Awesome 3.0 icons
		'cloud-download', 'cload-upload', 'lightbulb', 'exchange', 'bell-alt', 'beer', 'coffee', 'food', 'fighter-jet', 'user-md', 'stethoscope', 'suitcase', 'building', 'hospital', 'ambulance', 'medkit', 'h-sign', 'plus-sign-alt', 'spinner', 'angle-left', 'angle-right', 'angle-up', 'angle-down', 'double-angle-left', 'double-angle-right', 'double-angle-up', 'double-angle-down', 'circle-blank', 'circle', 'desktop', 'laptop', 'tablet', 'mobile-phone', 'quote-left', 'quote-right', 'reply', 'github-alt', 'folder-close-alt', 'folder-open-alt', 
		// Font Awesome 2.0 icons
		'glass', 'music', 'search', 'envelope', 'heart', 'star', 'star-empty', 'user', 'film', 'th-large', 'th', 'th-list', 'ok', 'remove', 'zoom-in', 'zoom-out', 'off', 'signal', 'cog', 'trash', 'home', 'file', 'time', 'road', 'download-alt', 'download', 'upload', 'inbox', 'play-circle', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'indent-left', 'indent-right', 'facetime-video', 'picture', 'pencil', 'map-marker', 'adjust', 'tint', 'edit', 'share', 'check', 'move', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-sign', 'minus-sign', 'remove-sign', 'ok-sign', 'question-sign', 'info-sign', 'screenshot', 'remove-circle', 'ok-circle', 'nam-circle', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'share-alt', 'resize-full', 'resize-small', 'plus', 'minus', 'asterisk', 'exclamation-sign', 'gift', 'leaf', 'fire', 'eye-open', 'eye-close', 'warning-sign', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder-close', 'folder-open', 'resize-vertical', 'resize-horizontal', 'bar-chart', 'twitter-sign', 'facebook-sign', 'camera-retro', 'key', 'cogs', 'comments', 'thumbs-up', 'thumbs-down', 'star-half', 'heart-empty', 'signout', 'linkedin-sign', 'pushpin', 'external-link', 'signin', 'trophy', 'github-sign', 'upload-alt', 'lemon', );
		return asort( $icons );
	}
	
	/**
     * Register Font Awesome
     * 
     * Two filters: wp_font_awesome_args & wp_font_awesome_ie7_args
     */
    public function register_styles() {
        global $wp_styles;
		
		$args = $this->get_args( 'font-awesome' );
		if ( false !== $args && is_array( $args ) )
			wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		
		$args = $this->get_args( 'font-awesome-ie7' );
		if ( false !== $args && is_array( $args ) ) {
			wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
			$wp_styles->add_data( $args['handle'], 'conditional', 'lte IE 7' );
		}
    }
	
	/**
     * Get Font Awesome Args
     * 
	 * Filter: wp_font_awesome_args - must return array()
     */
	private function get_args( $handle ) {
		$this->handles[] = $handle;
		
		return apply_filters(
			'wp_font_awesome_args',
			array(
				'handle' => $handle,
				'src'    => plugins_url( 'lib/css/' . $this->suffix( $handle ), __FILE__  ),
				'deps'   => array(),
				'ver'    => '3.0',
				'media'  => 'all',
			),
			$handle
		);
	}
	
	/**
     * Enqueue Font Awesome
     * 
     * Style can be prevented via wp_font_awesome_remove custom field.
     */
    public function enqueue_styles() {
		global $post;
		foreach( $this->handles as $handle ) {
			if ( ! get_post_meta( $post->ID, 'wp_font_awesome_remove', true ) && apply_filters( 'wp_font_awesome_enqueue', true, $post ) )
				wp_enqueue_style( $handle );
		}
		
    }
	
	/**
     * Font Awesome Shortcode
     * Use: [icon name="icon-pencil"]
     */
    public function shortcode( $atts ) {
		$this->enqueue_styles();
		
        extract(
			shortcode_atts(
				array(
					'name' => 'icon-wrench',
					'tag'  => 'i',
				), 
				$atts
			)
		);
		
        if ( strpos( $name, 'icon' ) )
			$icon = '<' . $tag . ' class="' . $name . '">&nbsp;</' . $tag . '>';
		else
			$icon = '<' . $tag . ' class="icon-' . $name . '">&nbsp;</' . $tag . '>';

        return $icon;
    }
	
}

/**
 * WP Smith Scripts Class
 *
 */
class WPS_Scripts {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance;
	
	/**
	 * Holds a copy of the handles.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $handles = array();
	
    /**
     * Constructor Method
     * 
     */
    public function __construct() {
        add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
    }
	
	/**
      * Builds style suffix for font awesome CSS files based on WP_DEBUG or SCRIPT_DEBUG
      * 
      * @param string $script Base name of file
      * 
      * @return string $script Full file name
      */
	public function suffix( $script ) {
	
		$script  = ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? $script . '.css' : $script . '.min.css';

		return $script;
	}
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}

}

// Instantiate
$_wp_font_awesome = new WP_Font_Awesome();