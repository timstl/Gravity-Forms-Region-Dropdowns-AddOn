<?php
if ( class_exists( 'GFForms' ) ) {
GFForms::include_addon_framework();

class GFAddressDropdowns extends GFAddOn {

	protected $_version = GF_ADDRESS_DROPDOWNS_VER;
	protected $_min_gravityforms_version = '1.9.13';
	protected $_slug = 'gfaddressdropdowns';
	protected $_path = 'gf-region-dropdowns/gf-region-dropdowns.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Region Dropdowns';
	protected $_short_title = 'Region Dropdowns';
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
	}*/

	public function form_settings_fields($form) {
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
					'title'	   => 'State / Province Format',
					'description' => 'Format dropdowns using full state names (default) or abbreviations.',
					'fields'	  => array(
						 array(
							 'type'		  => 'radio',
							 'name'		  => 'stateformat',
							 'label'		 => 'Format',
							 'default_value' => 'Full Name',
							 'horizontal'	=> true,
							 'choices'	   => array(
													array(
														'name'   => 'fullname',
														'tooltip'=> '',
														'label'  => 'Full Name',
														'value'  => 'fullname'
													),
													array(
														'name'	=> 'abbreviations',
														'tooltip' => '',
														'label'   => 'Abbreviations',
													),
												),
						),
					 )
			));
	}

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
		add_filter( 'gform_pre_render', array($this, 'add_form_class') );
	}

	public function init_ajax(){
		parent::init_ajax();
	}
	
	public function enqueue_scripts( $form = '', $is_ajax = false ) {
		if (wp_script_is( 'gfad', 'enqueued' )) {
			return; 
		}
		
		$gfad = array('states' => GFCommon::get_us_states(), 'provinces' => GFCommon::get_canadian_provinces());
		wp_enqueue_script( 'gfad', $this->get_base_url() . '/js/gfad.js',  array('jquery'),  $this->_version, true);
		wp_localize_script( 'gfad', 'gfad_regions', $gfad );
	}

	public function add_form_class( $form ) {
		
		if (! empty( $form['cssClass'])) { 
			$form['cssClass'] .= ' gfad_form';
		} else {
			$form['cssClass'] = 'gfad_form';
			
		}
		
		return $form;
	}
}
}
?>