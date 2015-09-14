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
					'title'	   => 'State Display Format',
					'description' => 'Format dropdown DISPLAY using full state names (default) or abbreviations. This is the label seen by visitors using the dropdown.',
					'fields'	  => array(
						 array(
							 'type'		  => 'radio',
							 'name'		  => 'statedisplayformat',
							 'label'		 => 'Format',
							 'default_value' => 'fullname',
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
														'value' => 'abbreviations'
													),
												),
						),
					 )
			),
				array(
					'title'	   => 'State Value Format',
					'description' => 'Format dropdown VALUES using full state names (default) or abbreviations. This is the value saved in submitted entries.',
					'fields'	  => array(
						 array(
							 'type'		  => 'radio',
							 'name'		  => 'statevalueformat',
							 'label'		 => 'Format',
							 'default_value' => 'fullname',
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
														'value' => 'abbreviations'
													),
												),
						),
					 )
			),
					array(
					'title'	   => 'Extra US Territory Abbreviations',
					'description' => '',
					'fields'	  => array(
						 array(
							 'type'		  => 'checkbox',
							 'name'		  => 'custompairs',
							 'label'	  => '',
							 'choices'	  => array(
								 				array(
													'name'   => 'custompairs[AA]',
													'tooltip'=> '',
													'label'  => 'AA',
													'value'  => 'AA'
												),
								 				array(
													'name'   => 'custompairs[AE]',
													'tooltip'=> '',
													'label'  => 'AE',
													'value'  => 'AE'
												),
								 				array(
													'name'   => 'custompairs[AP]',
													'tooltip'=> '',
													'label'  => 'AP',
													'value'  => 'AP'
												),
								 				array(
													'name'   => 'custompairs[AS]',
													'tooltip'=> '',
													'label'  => 'AS',
													'value'  => 'AS'
												),
								 				array(
													'name'   => 'custompairs[FM]',
													'tooltip'=> '',
													'label'  => 'FM',
													'value'  => 'FM'
												),
								 				array(
													'name'   => 'custompairs[GU]',
													'tooltip'=> '',
													'label'  => 'GU',
													'value'  => 'GU'
												),
								 				array(
													'name'   => 'custompairs[MH]',
													'tooltip'=> '',
													'label'  => 'MH',
													'value'  => 'MH'
												),
								 				array(
													'name'   => 'custompairs[MP]',
													'tooltip'=> '',
													'label'  => 'MP',
													'value'  => 'MP'
												),
								 				array(
													'name'   => 'custompairs[PW]',
													'tooltip'=> '',
													'label'  => 'PW',
													'value'  => 'PW'
												),
								 				array(
													'name'   => 'custompairs[PR]',
													'tooltip'=> '',
													'label'  => 'PR',
													'value'  => 'PR'
												),
								 				array(
													'name'   => 'custompairs[VI]',
													'tooltip'=> '',
													'label'  => 'VI',
													'value'  => 'VI'
												)
											)
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

		$states_full = GFCommon::get_us_states();
		$provinces_full = GFCommon::get_canadian_provinces();
		$states = array();
		$provinces = array();

		foreach ($states_full as $state_full) {
			
			$key = $state_full;
			$value = $state_full;
			
			if ($this->get_plugin_setting('statevalueformat') == 'abbreviations') {
				$key = GFCommon::get_us_state_code($state_full);
			}
			
			if ($this->get_plugin_setting('statedisplayformat') == 'abbreviations') {
				$value = GFCommon::get_us_state_code($state_full);
			}
			
			$states[$key] = $value;
		}
		
		$extra_states = $this->get_plugin_setting('custompairs');
		if (!empty($extra_states)) { 
			foreach ($extra_states as $key=>$value) {
				if ($value == 1) {
					$states[$key] = $key;
				}
			}
		}
					
		foreach ($provinces_full as $prov_full) {
			$provinces[$prov_full] = $prov_full;
		}
		
		asort($states);
		asort($provinces);

		$gfad = array('states' => $states, 'provinces' => $provinces);

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