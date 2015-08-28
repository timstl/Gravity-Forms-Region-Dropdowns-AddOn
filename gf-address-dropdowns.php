<?php
/*
 Plugin Name: Gravity Forms Address Dropdowns AddOn
 Plugin URI: http://timgweb.com/gf-address-dropdowns/
 Description: Plugin to insert state and province dropdowns for US and CA into Gravity Forms international address fields.
 Version: 1.0
 Author: Tim Gieseking
 Author URI: http://timgweb.com
 Text Domain: gf-address-dropdowns
 */
 
define( 'GF_ADDRESS_DROPDOWNS_VER', '1.0' );

add_action( 'gform_loaded', array( 'GFAddressDropdowns_Bootstrap', 'load' ), 5 );
class GFAddressDropdowns_Bootstrap {

	public static function load(){

		if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
			return;
		}

		require_once( plugin_dir_path( __FILE__ ) . 'class.gfaddressdropdowns.php' );
		GFAddOn::register( 'GFAddressDropdowns' );
	}

}

function gf_addressdropdowns(){
	return GFAddressDropdowns::get_instance();
}
?>