// We define a function that takes one parameter named $.
(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			// alter project input field types
			$('#edit-field-population-und-0-value').attr('type','number');
			$('#edit-field-discount-rate-und-0-value').attr('type','number');
			$('#edit-field-ci-cost-und-0-value').attr('type','number');
			$('#edit-field-exchange-rate-to-usd-und-0-value').attr('type','number');
			$('#edit-field-exchange-rate-to-usd-und-0-value').attr('step',0.01);
			
			// currency info pre-load
			function loadExchangeRate(terms,tid) {
				// get exchange rate from json-encoded taxonomy term
				//console.log ('tid: '+tid);
				if (terms[tid]){
					//console.log(terms[tid]);
					exchRate = terms[tid].field_exchange_rate['und'][0].value;
					currCode = terms[tid].field_currency_code['und'][0].value;
					//console.log('exchRate: '+exchRate);
					//console.log('currCode: '+currCode);
					$('#edit-field-exchange-rate-to-usd-und-0-value').val(exchRate);
					if (currCode == 'USD'){
						$('#field-exchange-rate-to-usd-add-more-wrapper').hide();
						//$('#field-exchange-rate-to-usd-add-more-wrapper').css('display','none');
					}
				}
			}
			
			var currencyTerms = Drupal.settings.taxonomy.currency;
			//var currencyTIds = new Array();
			//$('#project-node-form').ready(loadExchangeRate($('#edit-field-currency-und').val()));
			$('#project-node-form').ready(loadExchangeRate(currencyTerms,$('#edit-field-currency-und').val()));
			
			$('#edit-field-currency-und').change(function(){
				var termId = $(this).val();
				loadExchangeRate(currencyTerms,termId);
			});
		}
	};
}(jQuery));
