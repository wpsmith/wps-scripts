<?php

/**
 * Pretty Photo Class
 * Version: 3.1.5
 *
 * @link https://github.com/scaron/prettyphoto
 * @link http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/
 * @link http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/documentation
 */
if ( class_exists( 'WPS_Scripts' ) ) {
class WPSS_PrettyPhoto extends WPS_Scripts {
	
	/**
	 * Github repo name.
	 *
	 * @since 1.0.0
	 *
	 * @var script
	 */
	public $library = 'prettyphoto';
	
	/**
	 * Plugin Name.
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	public $plugin_name = 'WPS Scripts - Pretty Photo for WordPress';
	
	/**
     * Constructor Method
     * 
     */
    public function __construct() {
        parent::__construct();
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
			// Register Styles
			//add_action( 'init', array( $this, 'register_scripts' ) );
			
			// Enqueue Styles
			//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'plugins_loaded', array( $this, 'loaded' ) );
    }
	
	/**
     * Hooks plugin into all basic
     * 
     */
    public function loaded() {
		
		// Instantiate Pretty Photo in Footer after footer wp_enqueue_scripts
		$hook = apply_filters( 'wpss_init_hook_prettyphoto', array( 'wp_print_footer_scripts', 99 ) );
		if ( is_array( $hook ) )
			add_action( $hook[0], array( $this, 'init_prettyphoto' ), $hook[1] );
		        
    }
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @params      $network_wide   True if WPMU superadmin uses "Network Activate" action, 
	 *								false if WPMU is disabled or plugin is activated on an individual blog
	 */
	protected function activation() {
		
	}
	
	/**
     * Register Scripts
     * 
     */
    public function register_scripts() {
		
		$args = $this->get_args( 'wpss-prettyphoto', 'css' );
		if ( false !== $args && is_array( $args ) )
			wp_register_style( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		
		$args = $this->get_args( 'wpss-prettyphoto', 'js' );
		if ( false !== $args && is_array( $args ) )
			wp_register_script( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['media'] );
		
    }
	
	/**
     * Get Pretty Photo Args
     * 
     */
	protected function get_args( $handle, $type = 'css', $args = array() ) {
		
		if ( 'css' == $type ) {
			$file = 'prettyPhoto';
			$this->css_handles[] = $handle;
		} else {
			$file = 'jquery.prettyPhoto';
			$this->js_handles[] = $handle;
		}
		
		$defaults = apply_filters(
			'wpss_' . $this->_lib_name() . '_default_args',
			array(
				'handle' => $handle,
				'src'    => plugins_url( 'lib/' . $this->library . "/{$type}/" . call_user_func( array( $this, 'suffix_' . $type ), $file ), WPSS_PLUGIN_DIR ),
				//$this->suffix_( $handle )
				'deps'   => array(),
				'ver'    => '3.1.5',
				'media'  => 'all',
			),
			$handle
		);
		
		$args = wp_parse_args( $args, $defaults );			
		
		return apply_filters( 'wpss_' . $this->_lib_name() . '_args', $args, $handle );
	}
	
	/**
     * Enqueue Script
     * 
     * Style can be prevented via wp_font_awesome_remove custom field.
     */
    public function enqueue_scripts() {
		global $post;
		
		foreach( $this->css_handles as $handle ) {
			if ( ! get_post_meta( $post->ID, 'wpss_prettyphoto_remove', true ) && apply_filters( 'wpss_prettyphoto_enqueue', true, $post ) )
				wp_enqueue_style( $handle );
		}
		
		foreach( $this->js_handles as $handle ) {
			if ( ! get_post_meta( $post->ID, 'wpss_prettyphoto_remove', true ) && apply_filters( 'wpss_prettyphoto_enqueue', true, $post ) )
				wp_enqueue_script( $handle );
		}
		
    }
	
	/**
	 * Instantiate Pretty Photo
	 *
	 */
	function init_prettyphoto() {
	
		// Allow developers to short circuit
		$pre = apply_filters( 'wpss_init_prettyphoto', false );
		if ( $pre ) return;
		
		// Dynamic Selector
		$selector = apply_filters( 'wpss_selector_prettyphoto', "a[rel^='prettyPhoto']" );
	?>
<script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function($){
    $("<?php echo $selector; ?>").prettyPhoto();
  });
</script>
<?php
	}

}
}