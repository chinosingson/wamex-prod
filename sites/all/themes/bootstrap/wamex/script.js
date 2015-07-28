// We define a function that takes one parameter named $.
(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			// alter project input field types
			if ($('body.page-node-add-project, body.page-node-edit.node-type-project').length > 0) {
			
				$('#edit-field-population-und-0-value').attr('type','number');
				$('#edit-field-discount-rate-und-0-value').attr('type','number');
				$('#edit-field-ci-cost-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('step',0.01);
				
				// currency info pre-load
				var currencyTerms = Drupal.settings.taxonomy.currency;
				var nodeExchRate = Drupal.settings.node.values.field_exchange_rate_to_usd;
				function loadExchangeRate(tid,reset) {
					// get exchange rate from json-encoded taxonomy term
					//console.log ('tid: '+tid);
					if (currencyTerms[tid]){
						//console.log(terms[tid]);
						exchRate = currencyTerms[tid].field_exchange_rate['und'][0].value;
						currCode = currencyTerms[tid].field_currency_code['und'][0].value;
						//console.log('exchRate: '+exchRate);
						//console.log('currCode: '+currCode);
						//console.log(Drupal.settings.node.values.field_exchange_rate_to_usd);
						if (nodeExchRate==0 || nodeExchRate==null || reset){
							$('#edit-field-exchange-rate-to-usd-und-0-value').val(exchRate);
						} else {
							console.log('nodeExchRate: '+nodeExchRate);
							$('#edit-field-exchange-rate-to-usd-und-0-value').val(nodeExchRate);
						}
						if (currCode == 'USD'){
							$('#field-exchange-rate-to-usd-add-more-wrapper').hide();
						} else {
							$('#field-exchange-rate-to-usd-add-more-wrapper').show();
						}
					} else {
						$('#field-exchange-rate-to-usd-add-more-wrapper').show();
						$('#edit-field-exchange-rate-to-usd-und-0-value').val(null);
					}
					//console.log($('#edit-field-exchange-rate-to-usd-und-0-value').val());
				}
				
				//var currencyTIds = new Array();
				//$('#project-node-form').ready(loadExchangeRate($('#edit-field-currency-und').val()));
				//$('#project-node-form').ready(loadExchangeRate($('#edit-field-currency-und').val()));
				$('#project-node-form').ready(function(){
					// load default value on form ready
					loadExchangeRate($('#edit-field-currency-und').val(),0);
					
				});
				
				$('#reset-exchange-rate').on('click',function(){
					//console.log('reset');
					loadExchangeRate($('#edit-field-currency-und').val(),1);
					
				});
				
				// field_currency behavior
				$('#edit-field-currency-und').change(function(){
					//console.log('currency changed');
					//console.log('nodeExchRate: '+nodeExchRate);
					var termId = $(this).val();
					//if (nodeExchRate==0 || nodeExchRate==null){
						//console.log('ITO');
						loadExchangeRate(termId,1);
					//}
				});
			}
		}
	};
}(jQuery));
