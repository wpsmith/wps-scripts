<?php

/**
 * Skeleton Class
 * Version: x.x.x
 *
 */
if ( class_exists( 'WPS_Scripts' ) ) {
class WPSS_Name extends WPS_Scripts {
	
	/**
	 * Github repo name.
	 *
	 * @since 1.0.0
	 *
	 * @var script
	 */
	public $library = 'slug';
	
	/**
	 * Plugin Name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $plugin_name = 'WPS Scripts - Name for WordPress';
	
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
     * Register Scripts
     * 
     */
    public function register_scripts() {

		$args = $this->get_args( 'font-awesome' );
		if ( false !== $args && is_array( $args ) )
			wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		
    }
	
	/**
     * Get Name Args
     * 
     */
	protected function get_args( $handle, $args = array() ) {
		$this->handles[] = $handle;
		
		$defaults = apply_filters(
			'wpss_' . str_replace( '-', '_', $this->library ) . '_default_args',
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
		
		return apply_filters( 'wpss_' . str_replace( '-', '_', $this->library ) . '_args', $args, $handle );
	}
	
	/**
     * Enqueue Script
     * 
     * Style can be prevented via wp_font_awesome_remove custom field.
     */
    public function enqueue_scripts() {
		global $post;
		foreach( $this->handles as $handle ) {
			if ( ! get_post_meta( $post->ID, 'wp_font_awesome_remove', true ) && apply_filters( 'wp_font_awesome_' . str_replace( 'font-awesome-', '', $handle ) . '_enqueue', true, $post ) )
				wp_enqueue_style( $handle );
		}
		
    }
	
}
}