jQuery(document).ready(function($)
{
	function gfad_region_set($countryf, $statef) {
		if ($countryf.val() == 'United States') {
			$statef.children('input[type="text"]').hide();
			$statef.children('.gfad_ca').hide();
			$statef.children('.gfad_us').show();
		}
	}
	
	$('.gform_wrapper').each(function(x) {
		/* find any address inputs with state and country */
		$(this).find('.has_state.has_country').each(function(i) {
			var $address = $(this),
				$statef = $address.find('address_state');
			
			if ($statef.children('input[type="text"]').length > 0) {
				$statef.append('<select id="states_us_' + x + '_' + i + '" class="gfad_us"></select>');
				$statef.append('<select id="states_us_' + x + '_' + i + '" class="gfad_ca"></select>');
				
				var $countryf = $statef.closest('.has_country').find('.address_country > select');
				if ($countryf.length > 0) {
					gfad_region_set($countryf, $statef);
				}
			}
			
		});
	});
});