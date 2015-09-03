﻿// We define a function that takes one parameter named $.
(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			// alter project input field types
			if ($('body.page-node-add-project, body.page-node-edit.node-type-project, body.page-dashboard').length > 0) {
				//console.log('check');
			
				$('#edit-field-population-und-0-value').attr('type','number');
				$('#edit-field-discount-rate-und-0-value').attr('type','number');
				$('#edit-field-ci-cost-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('step',0.01);
				
				// currency info pre-load
				var currencyTerms = Drupal.settings.taxonomy.currency;
				//console.log(currencyTerms);
				var nodeExchRate = Drupal.settings.node.values.field_exchange_rate_to_usd;
				//console.log(nodeExchRate);
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
					//console.log(event);
					$('#view-wamex-projects-canvas').removeClass('hidden');
					$('#view-wamex-projects-canvas').show();
					$('#add-project').addClass('disabled');
					$('#cancel-project').removeClass('hidden');
					//console.log($('#view-wamex-projects-canvas').css('display'));
					document.getElementById('view-wamex-projects-canvas').scrollIntoView();
					//console.log('toggle');
					//$('#view-wamex-projects-canvas').load('node/add/project');
					//$('#view-wamex-projects-canvas').html('display node/add/project here.');
				});
				
				$('#cancel-project').on('click',function(event){
					$('#view-wamex-projects-canvas').addClass('hidden');
					$('#view-wamex-projects-canvas').hide();
					$('#add-project').removeClass('disabled');
					$('#cancel-project').addClass('hidden');
				});
				
				/*if ($('#view-wamex-projects-canvas').is(':hidden')){
					console.log('#view-wamex-projects-canvas HIDDEN');
				} else {
					console.log('#view-wamex-projects-canvas SHOWN');
				}
				
				$('#view-wamex-projects-canvas').on('show', function(event){
					console.log('#view-wamex-projects-canvas SHOWN');
				});

				$('#view-wamex-projects-canvas').on('hide', function(event){
					console.log('#view-wamex-projects-canvas HIDDEN');
				});*/
			}
			
			
		}
	};
}(jQuery));
