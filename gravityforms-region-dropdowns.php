<?php
/*
 Plugin Name: Region Dropdowns AddOn for Gravity Forms
 Description: Plugin to insert state and province dropdowns for US and CA into Gravity Forms international address fields.
 Version: 1.0.3
 Author: Atomicdust
 Author URI: http://atomicdust.com
 Text Domain: gf-address-dropdowns
 
------------------------------------------------------------------------
Copyright 2015 Atomicdust

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses.
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