<?php

/**
 * Font Awesome Class
 * Version: 3.0.1
 *
 */
if ( class_exists( 'WPS_Scripts' ) ) {
class WPSS_Font_Awesome extends WPS_Scripts {
	
	/**
	 * Github repo name.
	 *
	 * @since 1.0.0
	 *
	 * @var script
	 */
	public $library = 'font-awesome';
	
	/**
	 * Plugin Name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $plugin_name = 'WPS Scripts - Font Awesome for WordPress';
	
	
	/**
     * Constructor Method
     * 
     */
    public function __construct() {
        parent::__construct();
		add_action( 'plugins_loaded', array( $this, 'loaded' ) );
    }
	
	/**
     * Hooks plugin into all basic
     * 
     * @todo Updater doesn't need to run on every admin page
     */
    public function loaded() {
		
		// Add Shortcodes
		add_shortcode( 'icon', array( $this, 'shortcode' ) );
		
		// Add shortcode to widgets
        add_filter( 'widget_text', 'do_shortcode' );
        
    }
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @params      $network_wide   True if WPMU superadmin uses "Network Activate" action, 
	 *								false if WPMU is disabled or plugin is activated on an individual blog
	 */
	protected function activation() {
		if ( ! class_exists( 'WPS_Scripts' ) ) {
			if ( ! function_exists( 'deactivate_plugins' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			add_action( 'admin_notices', array( $this, 'deactivation_message' ), 5 );
		}
		
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
			'glass', 'music', 'search', 'envelope', 'heart', 'star', 'star-empty', 'user', 'film', 'th-large', 'th', 'th-list', 'ok', 'remove', 'zoom-in', 'zoom-out', 'off', 'signal', 'cog', 'trash', 'home', 'file', 'time', 'road', 'download-alt', 'download', 'upload', 'inbox', 'play-circle', 'repeat', 'refresh', 'list-alt', 'lock', 'flag', 'headphones', 'volume-off', 'volume-down', 'volume-up', 'qrcode', 'barcode', 'tags', 'book', 'bookmark', 'print', 'camera', 'font', 'bold', 'italic', 'text-height', 'text-width', 'align-left', 'align-center', 'align-right', 'align-justify', 'list', 'indent-left', 'indent-right', 'facetime-video', 'picture', 'pencil', 'map-marker', 'adjust', 'tint', 'edit', 'share', 'check', 'move', 'step-backward', 'fast-backward', 'backward', 'play', 'pause', 'stop', 'forward', 'fast-forward', 'step-forward', 'eject', 'chevron-left', 'chevron-right', 'plus-sign', 'minus-sign', 'remove-sign', 'ok-sign', 'question-sign', 'info-sign', 'screenshot', 'remove-circle', 'ok-circle', 'nam-circle', 'arrow-left', 'arrow-right', 'arrow-up', 'arrow-down', 'share-alt', 'resize-full', 'resize-small', 'plus', 'minus', 'asterisk', 'exclamation-sign', 'gift', 'leaf', 'fire', 'eye-open', 'eye-close', 'warning-sign', 'plane', 'calendar', 'random', 'comment', 'magnet', 'chevron-up', 'chevron-down', 'retweet', 'shopping-cart', 'folder-close', 'folder-open', 'resize-vertical', 'resize-horizontal', 'bar-chart', 'twitter-sign', 'facebook-sign', 'camera-retro', 'key', 'cogs', 'comments', 'thumbs-up', 'thumbs-down', 'star-half', 'heart-empty', 'signout', 'linkedin-sign', 'pushpin', 'external-link', 'signin', 'trophy', 'github-sign', 'upload-alt', 'lemon', 
		);
		
		return asort( $icons );
	}
	
	/**
     * Register Font Awesome
     * 
     */
    public function register_scripts() {
		$args = $this->get_args( 'font-awesome' );
		if ( false !== $args && is_array( $args ) )
			wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		
		$args = $this->get_args( 'font-awesome-ie7' );
		if ( false !== $args && is_array( $args ) )
			$this->register_conditional_style( $args, 'lte IE 7' );
    }
	
	/**
     * Get Font Awesome Args
     * 
	 * Filter: wp_font_awesome_args - must return array()
     */
	protected function get_args( $handle, $args = array() ) {
		$this->css_handles[] = $handle;
		
		$defaults = apply_filters(
			'wpss_' . $this->_lib_name() . '_default_args',
			array(
				'handle' => $handle,
				'src'    => plugins_url( 'lib/' . $this->library . '/css/' . $this->suffix_css( $handle ), WPSS_PLUGIN_DIR ),
				'deps'   => array(),
				'ver'    => '3.0',
				'media'  => 'all',
			),
			$handle
		);
		
		$args = wp_parse_args( $args, $defaults );
		
		return apply_filters( 'wpss_' . $this->_lib_name() . '_args', $args, $handle );
	}
	
	/**
     * Enqueue Font Awesome
     * 
     * Style can be prevented via wp_font_awesome_remove custom field.
     */
    public function enqueue_scripts() {
		global $post;
		foreach( $this->css_handles as $handle ) {
			if ( ! get_post_meta( $post->ID, 'wp_font_awesome_remove', true ) && apply_filters( 'wpss_font_awesome_' . str_replace( '-', '_', str_replace( 'font-awesome-', '', $handle ) ) . '_enqueue', true, $post ) )
				wp_enqueue_style( $handle );
		}
		
    }
	
	/**
     * Font Awesome Shortcode
     * Use: [icon name="icon-pencil"]
     */
    public function shortcode( $atts ) {
		$this->enqueue_scripts();
		
		$args = apply_filters(
			'wpss_' . $this->_lib_name() . '_sc_default_args',
			array(
				'name'  => 'icon-wrench',
				'tag'   => 'i',
				'style' => '',
				'size'  => '',
			)
		);
		
		// Try to be dummy proof
		// use 'icon' instead of 'name'
		if ( isset( $atts['icon'] ) )
			$atts['name'] = $atts['icon'];
		
		// use nothing, assume they wanted the icon with that name
		if ( ! isset( $atts['name'] ) && ! isset( $atts['icon'] ) && ! isset( $atts['tag'] ) && isset( $atts[0] ) )
			$atts['name'] = $atts[0];
		
		// use nothing, assume they wanted the size set
		if ( ! isset( $atts['size'] ) && ! isset( $atts['style'] ) && isset( $atts[1] ) )
			$atts['size'] = $atts[1];
		
        extract( shortcode_atts( $args, $atts ) );
		
		// Start Pattern
		$pattern = '<%1$s class="%2$s"';
		
		// Get class
        if ( preg_match( '/^icon/', $name ) )
			$class = $name;
		else
			$class = 'icon-' . $name;
		
		// Add style, assume size is pixels
		if ( '' != $size && '' == $style )
			$style = 'font-size: ' . $size . 'px;';
		
		// Close Pattern
		if ( '' != $style ) {
			$pattern .= ' style="%3$s">&nbsp;</%1$s>';
			$icon = sprintf( $pattern, $tag, $class, $style );
		}
		else {
			$pattern .= '>&nbsp;</%1$s>';
			$icon = sprintf( $pattern, $tag, $class );
		}
		
        return $icon;
    }
	
}
}