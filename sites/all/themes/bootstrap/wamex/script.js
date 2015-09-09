// We define a function that takes one parameter named $.
(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			// alter project input field types
			if ($('body.page-node-add-project, body.page-node-edit.node-type-project, body.page-dashboard').length > 0) {
				//console.log('check');
				//console.log($('body.page-dashboard').length);
			
				$('#edit-field-population-und-0-value').attr('type','number');
				$('#edit-field-discount-rate-und-0-value').attr('type','number');
				$('#edit-field-ci-cost-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('step',0.01);
				
				// currency info pre-load
				var currencyTerms = Drupal.settings.taxonomy.currency;
				//console.log(currencyTerms);
				var nodeExchRate = Drupal.settings.node.values.field_exchange_rate_to_usd;
				function loadExchangeRate(tid,reset) {
					// get exchange rate from json-encoded taxonomy term
					//console.log ('tid: '+tid);
					//console.log ('reset: '+reset);
					if (currencyTerms[tid]){
						//console.log(currencyTerms[tid]);
						exchRate = currencyTerms[tid].field_exchange_rate['und'][0].value;
						currCode = currencyTerms[tid].field_currency_code['und'][0].value;
						//console.log('exchRate: '+exchRate);
						//console.log('currCode: '+currCode);
						//console.log(Drupal.settings.node.values.field_exchange_rate_to_usd);
						//console.log('nodeExchRate: '+nodeExchRate);
						if (nodeExchRate==0 || nodeExchRate==null || reset){
							$('#edit-field-exchange-rate-to-usd-und-0-value').val(exchRate);
						} else {
							$('#edit-field-exchange-rate-to-usd-und-0-value').val(nodeExchRate);
						}
						if (currCode == 'USD'){
							$('#field-exchange-rate-to-usd-add-more-wrapper').hide();
							$('#form-item-field-exchange-rate-to-usd-und-0-value').hide();
						} else {
							$('#field-exchange-rate-to-usd-add-more-wrapper').show();
							$('#form-item-field-exchange-rate-to-usd-und-0-value').show();
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

				$('#project-node-form-ajax').ready(function(){
					// load default value on form ready
					loadExchangeRate($('#edit-field-currency').val(),0);
					
				});

				$('#reset-exchange-rate').on('click',function(){
					//console.log('reset');
					loadExchangeRate($('#edit-field-currency-und').val(),1);
					
				});
				
				// field_currency behavior
				//console.log('nodeExchRate: '+nodeExchRate);
				$('#edit-field-currency-und').change(function(){
					//console.log('currency changed');
					//console.log('nodeExchRate: '+nodeExchRate);
					var termId = $(this).val();
					//if (nodeExchRate==0 || nodeExchRate==null){
						//console.log('ITO');
						loadExchangeRate(termId,0);
					//}
				});
				
				/*$('#edit-field-currency').change(function(){
					console.log('efc changed');
					var termId = $(this).val();
					console.log(termId);
					loadExchangeRate(termId,0);
				});*/
			}
			
			if($('body.page-node, body.node-type-project').length > 0){
				console.log('view project');
				//var nid = Drupal.settings.node.values.nid;
				$('#add-loading').on('click',function(){
					//$('#loading-form-container').load('add/loading/');
					//$('#loading-form-container').html('display node/add/loading here: ' + nid);
				});
				
				$('#refresh-loading-list').on('click', function(){
					$('#loading-list-container').html('display refreshed loading list here');
				});
			}
			
			if($('body.page-dashboard').length > 0){
				//var textShowForm = 'Add New Project';
				//var textHideForm = 'Cancel';
				//$('#add-project').html(textShowForm);
				//$('#view-wamex-projects-canvas').hide();
				$('#add-project').on('click',function(event){
					//console.log('wamex_ajax_load');
					$('#cancel-project').removeClass('hidden');
					// load the node/add/project form, and attach ajax behaviors to the container
					$('#view-wamex-projects-canvas').empty().html('<img src="/wamex/misc/throbber-active.gif" style="margin-left:50%;"/>');
					$('#view-wamex-projects-canvas').load('/wamex/get/ajax/node/add/project','ajax=1',function(){
						Drupal.attachBehaviors('#view-wamex-projects-canvas');
					});
				});
				
				$('#cancel-project').on('click',function(event){
					//$('#view-wamex-projects-canvas').addClass('hidden');
					//$('#view-wamex-projects-canvas').hide();
					$('#view-wamex-projects-canvas').empty();
					$('#add-project').removeClass('disabled');
					$('#cancel-project').addClass('hidden');
				});
				
			}
			
		}
	};
}(jQuery));
