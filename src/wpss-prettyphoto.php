<?php

/**
 * Plugin Name: WPS Scripts - Pretty Photo for WordPress
 * Plugin URI: http://wpsmith.net
 * Description: Use the Pretty Photo script within WordPress.
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

require_once( 'lib/classes/wps-scripts.php' );
define( 'WPSS_PLUGIN_NAME', 'WPS Scripts - Pretty Photo for WordPress' );
define( 'WPSS_PLUGIN_DIR', __FILE__ );
register_activation_hook( __FILE__, 'wpss_prettyphoto_activation' );
function wpss_prettyphoto_activation( $network_wide ) {
	if ( ! class_exists( 'WPS_Scripts' ) ) {
		if ( ! function_exists( 'deactivate_plugins' ) ) require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
		//wp_die( 'You can\'t do this! WPSS_PLUGIN_NAME: ' . WPSS_PLUGIN_NAME . '<br /> plugin_basename( __FILE__ ): ' . plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', 'wpss_prettyphoto_deactivation_message', 5 );
	}
}

function wpss_prettyphoto_deactivation_message() {
	printf(
		'<div id="wpss-prettyphoto-message" class="error"><p>%s<strong>%s</strong>%s</p></div><style type="text/css">#message { display: none; }</style>',
		__( 'Sorry, you can\'t activate ', 'wps-scripts' ),
		WPSS_PLUGIN_NAME,
		__( ' unless you have installed WPS Scripts Core.', 'wps-scripts' )
	);
}

if ( class_exists( 'WPS_Scripts' ) ) {
	require_once( 'lib/classes/prettyphoto.php' );
}

if ( class_exists( 'WPSS_PrettyPhoto' ) ) {
	$_wpss_prettyphoto = new WPSS_PrettyPhoto();
}