(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			// alter project input field types
			if ($('body.page-node-add-project, body.page-node-edit.node-type-project, body.page-dashboard').length > 0) {
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
					if (currencyTerms[tid]){
						exchRate = currencyTerms[tid].field_exchange_rate['und'][0].value;
						currCode = currencyTerms[tid].field_currency_code['und'][0].value;
						if (nodeExchRate==0 || nodeExchRate==null || reset){
							$('#edit-field-exchange-rate-to-usd-und-0-value').val(exchRate);
						} else {
							$('#edit-field-exchange-rate-to-usd-und-0-value').val(nodeExchRate);
						}
						if (tid != 2){
							$('#field-exchange-rate-to-usd-add-more-wrapper').removeClass('hidden');
							$('#field-exchange-rate-to-usd-add-more-wrapper').show();
							$('#form-item-field-exchange-rate-to-usd-und-0-value').show();
						} else {
							$('#field-exchange-rate-to-usd-add-more-wrapper').addClass('hidden');
							$('#field-exchange-rate-to-usd-add-more-wrapper').hide();
							$('#form-item-field-exchange-rate-to-usd-und-0-value').hide();
						}
					} else {
						$('#field-exchange-rate-to-usd-add-more-wrapper').show();
						//$('#edit-field-exchange-rate-to-usd-und-0-value').val(null);
					}
					//console.log($('#edit-field-exchange-rate-to-usd-und-0-value').val());
				}
				
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
				$('#edit-field-currency-und').unbind('change').change(function(){
					var termId = $(this).val();
					loadExchangeRate(termId,0);
				});
				
			}
			
			if($('body.page-node, body.node-type-project').length > 0){
			
				$('.form-loading-attribute').attr('type','number');
				var throbberPath = Drupal.settings.basePath+'misc/throbber-active.gif"';
				//var nid = Drupal.settings.node.values.nid;
				$('.btn-add-loading').unbind('click').on('click',function(){
					var viewport = $('#loading-form-container');
					if($('#cancel-loading').hasClass('hidden')) $('#cancel-loading').removeClass('hidden');
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var projectId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/add/'+projectId;
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-form-container');
					});
				});
				
				$('.project-delete-loading-btn').unbind('click').on('click',function(event){
					var viewport = $('#loading-form-container');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var nodeId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/delete/'+nodeId;
					$('#edit-loading-'+nodeId).addClass('disabled');
					$('#delete-loading-'+nodeId).addClass('disabled');
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-form-container');
					});
				});
				
				
				var rowStaticHtml = '';
				$('.project-edit-loading-btn').unbind('click').on('click',function(event){
					if($('#cancel-loading').hasClass('hidden')) $('#cancel-loading').removeClass('hidden');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var nodeId = idTokens[2];
					//var rowViewport = $('#loading-'+nodeId);
					var rowViewport = $('#loading-form-container');
					//console.log(rowViewport);
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/edit/'+nodeId;
					$('#edit-loading-'+nodeId).addClass('disabled');
					$('#delete-loading-'+nodeId).addClass('disabled');
					rowStaticHtml = rowViewport.html(); 
					//rowViewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					//$('#loading-'+nodeId+' td.view-field-display').addClass('hidden');
					rowViewport.append('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					rowViewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-form-container');
						$('.edit-loading-cancel').unbind('click').on('click',function(event){
							//console.log('#loading-'+nodeId);
							//console.log(rowStaticHtml);
							//$('#loading-'+nodeId+' td.view-field-edit').addClass('hidden');
							rowViewport.html(rowStaticHtml);
							//rowViewport.add(rowStaticHtml);
							Drupal.attachBehaviors($('#loading-'+nodeId));
							rowStaticHtml = '';
						});
					});
				});
				
				$('#cancel-loading').unbind("click").on('click',function(event){
					var viewport = $('#loading-form-container');
					viewport.empty();
					$('.project-edit-loading-btn').removeClass('disabled');
					$('.project-delete-loading-btn').removeClass('disabled');
					$('.btn-add-loading').removeClass('disabled');
					$('#cancel-loading').addClass('hidden');
				});
				
				$('#edit-cancel').addClass('btn');
				$('#edit-cancel').addClass('btn-default');

				$('#edit-field-loading-type').unbind('change').on('change', function(event){
					//console.log('loading type changed');
					termIndex = $('#edit-field-loading-type')[0].selectedIndex-1;
					console.log(termIndex);
					termObj = Drupal.settings.taxonomy.loadingTypes[termIndex];
					//console.log(termObj); //.field_loading_adwf['und'][0].value); //[0].value);
					if (termIndex >= 0){
						$('#edit-field-loading-adwf').val(termObj.field_loading_adwf['und'][0].value);
						$('#edit-field-loading-bod5').val(termObj.field_loading_bod5['und'][0].value);
						$('#edit-field-loading-cod').val(termObj.field_loading_cod['und'][0].value);
						$('#edit-field-loading-totp').val(termObj.field_loading_totp['und'][0].value);
						$('#edit-field-loading-totn').val(termObj.field_loading_totn['und'][0].value);
						$('#edit-field-loading-tss').val(termObj.field_loading_tss['und'][0].value);
					} else {
						$('#edit-field-loading-adwf').val(0);
						$('#edit-field-loading-bod5').val(0);
						$('#edit-field-loading-cod').val(0);
						$('#edit-field-loading-totp').val(0);
						$('#edit-field-loading-totn').val(0);
						$('#edit-field-loading-tss').val(0);
					}
				});
				
				//#'view-project-loadings' tbody.views-field-field-loading-adwf
				function getAvg(selector,weightSelector){
					var average = 0;
					selector.each(function(){
						average = average + parseFloat($(this).text());
						//console.log(average);
					});
					average = average/selector.length;
					return average.toFixed(2);
				}
				

				$('#view-project-loadings').ready(function(){
					var adwf_avg = 0;
					var adwf_values = $('#view-project-loadings tbody td.views-field-field-loading-adwf');
					adwf_avg = getAvg(adwf_values);
					$('#ave_adwf').html(adwf_avg);

					var cod_avg = 0;
					var cod_values = $('#view-project-loadings tbody td.views-field-field-loading-cod');
					cod_avg = getAvg(cod_values);
					$('#ave_cod').html(cod_avg);

					var bod5_avg = 0;
					var bod5_values = $('#view-project-loadings tbody td.views-field-field-loading-bod5');
					bod5_avg = getAvg(bod5_values);
					$('#ave_bod5').html(bod5_avg);

					var totn_avg = 0;
					var totn_values = $('#view-project-loadings tbody td.views-field-field-loading-totn');
					totn_avg = getAvg(totn_values);
					$('#ave_totn').html(totn_avg);

					var totp_avg = 0;
					var totp_values = $('#view-project-loadings tbody td.views-field-field-loading-totp');
					totp_avg = getAvg(totp_values);
					$('#ave_totp').html(totp_avg);

					var tss_avg = 0;
					var tss_values = $('#view-project-loadings tbody td.views-field-field-loading-tss');
					tss_avg = getAvg(tss_values);
					$('#ave_tss').html(tss_avg);

				});
				
			}
			
			if($('body.page-dashboard').length > 0){
				var throbberPath = Drupal.settings.basePath+'misc/throbber-active.gif"';
				var viewport = $('#dashboard-projects-viewport');
				$('#add-project').unbind("click").on('click',function(event){
					if($('#cancel-project').hasClass('hidden')) $('#cancel-project').removeClass('hidden');
					// load the /project/add custom form, and attach ajax behaviors to the container
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/project/add';
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#dashboard-projects-viewport');
					});
				});
				
				$('.dashboard-edit-project-btn').unbind("click").on('click',function(event){
					if($('#cancel-project').hasClass('hidden')) $('#cancel-project').removeClass('hidden');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var nodeId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/project/edit/'+nodeId;
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#dashboard-projects-viewport');
					});
				});
				
				$('.dashboard-delete-project-btn').unbind('click').on('click',function(event){
					//if($('#cancel-project').hasClass('hidden')) $('#cancel-project').removeClass('hidden');
					//else 
					$('#cancel-project').addClass('hidden');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var nodeId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/project/delete/'+nodeId;
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#dashboard-projects-viewport');
					});
				});
				
				$('#cancel-project').unbind("click").on('click',function(event){
					viewport.empty();
					$('#add-project').removeClass('disabled');
					$('#cancel-project').addClass('hidden');
				});
				
				$('#edit-cancel').addClass('btn');
				$('#edit-cancel').addClass('btn-default');
			}

			
		}
	};
}(jQuery));
