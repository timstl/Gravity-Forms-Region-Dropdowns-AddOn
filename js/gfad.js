;(function($) {
			
	$.gfad = function() {

		var $gfad = $('.gfad_form_wrapper');
		
		if ($gfad.length > 0) {
			
			/* check that we have state and province values to work with */
			if (gfad_regions == undefined || 
				gfad_regions.length <= 0 || 
				gfad_regions.states.length <= 0 || 
				gfad_regions.provinces.length <= 0) {
					return;
			}
			
			/* create options for our dropdowns */
			var stateopts = '<option value="" selected="selected"></option>',
				provopts = '<option value="" selected="selected"></option>';
			
			$.each(gfad_regions.states, function(k, v) {
				stateopts += '<option value="' + k + '">' + v + '</option>';
			});
	
			$.each(gfad_regions.provinces, function(k, v) {
				provopts += '<option value="' + k + '">' + v + '</option>';
			});
			
			/* display the proper region input */
			function gfad_map_text_to_select($countryf, $text, $us, $ca) {
				if (is_US($countryf)) {
					$us.val($text.val());
					$ca.val('');
					$us.show();
					$ca.hide();
					$text.hide();
				} else if (is_Canada($countryf)) {
					$ca.val($text.val());
					$us.val('');
					$us.hide();
					$ca.show();
					$text.hide();
				} else {
					$ca.val('');
					$us.val('');
					$us.hide();
					$ca.hide();
					$text.show();
				}
			}
			
			function gfad_map_select_to_text($sel, $text) {
				$text.val($sel.val());
			}
			
			function gfad_region_reset($countryf, $text, $us, $ca) {
				$text.val('');
				$us.val('');
				$ca.val('');
				
				if (is_US($countryf)) {
					$us.show();
					$ca.hide();
					$text.hide();
				} else if (is_Canada($countryf)) {
					$ca.show();
					$us.hide();
					$text.hide();
				} else {
					$ca.hide();
					$us.hide();
					$text.show();
				}			
			}
	
			function is_US($countryf) {
				if ($countryf.val() == 'United States') {
					return true;
				}
				
				return false;
			}
					
			function is_Canada($countryf) {
				if ($countryf.val() == 'Canada') {
					return true;
				}
				
				return false;			
			}
		
			/* loop through every form on the page */
			$gfad.each(function(x) 
			{
				/* find any address inputs with state and country */
				$(this).find('.has_state.has_country').each(function(i) {
					var $address = $(this),
						$statef = $address.find('.address_state'),
						$statetext = $statef.children('input[type="text"]'),
						tabindex = $statetext.attr('tabindex');
					/* Is there a text input for state? (International forms only) */
					if ($statetext.length > 0) {					
						/*
							Make sure we have a country field that can be changed.
							If we don't, form settings should be switched to US or CA instead of International.
						*/
						var $countryf = $statef.closest('.has_country').find('.address_country > select');
						if ($countryf.length > 0) {
							/* create state dropdowns, set to variable. */
							$('<select id="states_us_' + x + '_' + i + '" class="gfad_us" tabindex="' + tabindex + '>' + stateopts + '</select>').insertAfter($statetext);
							$('<select id="states_us_' + x + '_' + i + '" class="gfad_ca" tabindex="' + tabindex + '>' + provopts + '</select>').insertAfter($statetext);
							var $us = $statef.find('.gfad_us'),
								$ca = $statef.find('.gfad_ca');
							
							/* change displayed dropdown when country changes */					
							$countryf.on('change', function() {						
								gfad_region_reset($countryf, $statetext, $us, $ca);
							});
							
							/* set region text value when dropdown changes */
							$us.on('change', function() {
								if (is_US($countryf)) {
									gfad_map_select_to_text($(this), $statetext);
								}
							});
	
							$ca.on('change', function() {
								if (is_Canada($countryf)) {
									gfad_map_select_to_text($(this), $statetext);
								}
							});
							
							/* set values on load */
							gfad_map_text_to_select($countryf, $statetext, $us, $ca);
						}
					}
					
				});
			});
		}
	};
		
	// default options
})(jQuery);

jQuery(document).ready(function($)
{
	$.gfad();
});