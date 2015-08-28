<?php
if ( class_exists( 'GFForms' ) ) {
GFForms::include_addon_framework();

class GFAddressDropdowns extends GFAddOn {

	protected $_version = GF_ADDRESS_DROPDOWNS_VER;
	protected $_min_gravityforms_version = '1.9.13';
	protected $_slug = 'gfaddressdropdowns';
	protected $_path = 'gf-address-dropdowns/gf-address-dropdowns.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Address Dropdowns';
	protected $_short_title = 'GF Address Dropdowns';
	private static $_instance = null;

	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new GFAddressDropdowns();
		}

		return self::$_instance;
	}
	
	/*public function plugin_page() {
		?>
		This page appears in the Forms menu
		<?php
	}

	public function form_settings_fields() {
		return array(
			array(
				"title"  => "Simple Form Settings",
				"fields" => array(
					array(
						"label"   => "My checkbox",
						"type"	=> "checkbox",
						"name"	=> "enabled",
						"tooltip" => "This is the tooltip",
						"choices" => array(
							array(
								"label" => "Enabled",
								"name"  => "enabled"
							)
						)
					)
				)
			)
		);
	}

	public function plugin_settings_fields() {
		return array(
			array(
				"title"  => "Simple Add-On Settings",
				"fields" => array(
					array(
						"name"	=> "textbox",
						"tooltip" => "This is the tooltip",
						"label"   => "This is the label",
						"type"	=> "text",
						"class"   => "small"
					)
				)
			)
		);
	}*/

	public function pre_init(){
		parent::pre_init();
	}

	public function init(){
		parent::init();
	}

	public function init_admin(){
		parent::init_admin();
	}

	public function init_frontend(){
		parent::init_frontend();
		add_action('gform_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 2);
	}

	public function init_ajax(){
		parent::init_ajax();
	}
	
	public function enqueue_scripts( $form = '', $is_ajax = false ) {
		wp_enqueue_script( 'gfad', $this->get_base_url() . '/js/gfad.js',  array('jquery'),  $this->_version, true);
	}
}
}
?>