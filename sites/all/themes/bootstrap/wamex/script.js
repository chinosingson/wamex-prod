(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			function loadExchangeRate(termId,reset) {
				// get exchange rate from json-encoded taxonomy term
				// currency info pre-load
				var currencyTerms = Drupal.settings.taxonomy.currency;
				if (currencyTerms[termId]){
					exchRate = currencyTerms[termId].field_exchange_rate['und'][0].value;
					if (reset==1){
						// load values from JS
						//console.log('exch rate - load values from JS');
						$('#edit-field-exchange-rate-to-usd-und-0-value').val(exchRate);
					} /*else {
						// load values from node
						console.log('exch rate - load values from NODE');
						$('#edit-field-exchange-rate-to-usd-und-0-value').val(nodeExchRate);
					}*/
					if (termId != 2){
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
				}
			}

			function loadEffluentStandardAttributes(termIndex,reset) {	// ADD AN OVERRIDE ARG
				var termObj = Drupal.settings.taxonomy.effluentStandards[termIndex];
				var nodeEffluentStandard = Drupal.settings.node.values.field_effluent_standard;
				var nodeCOD = Drupal.settings.node.values.field_cod;
				var nodeBOD5 = Drupal.settings.node.values.field_bod5;
				var nodeTotN = Drupal.settings.node.values.field_totn;
				var nodeTotP = Drupal.settings.node.values.field_totp;
				var nodeTSS = Drupal.settings.node.values.field_tss;
				if(termObj){
					if(termObj.name != 'Custom'){
						// load values from js
						if(!$('#effluent-standard-values input').prop('disabled')){
							$('#effluent-standard-values input').attr('disabled',true);
						}
						if(!$('#edit-effl-submit').hasClass('hidden')){
							$('#edit-effl-submit').addClass('hidden');
						}
						$('#edit-field-cod').val((termObj.field_loading_cod.length === 0) ?  'N/A' : termObj.field_loading_cod['und'][0].value);
						$('#edit-field-bod5').val((termObj.field_loading_bod5.length === 0) ?  'N/A' : termObj.field_loading_bod5['und'][0].value);
						$('#edit-field-totn').val((termObj.field_loading_totn.length === 0) ?  'N/A' : termObj.field_loading_totn['und'][0].value);
						$('#edit-field-totp').val((termObj.field_loading_totp.length === 0) ?  'N/A' : termObj.field_loading_totp['und'][0].value);
						$('#edit-field-tss').val((termObj.field_loading_tss.length === 0) ?  'N/A' : termObj.field_loading_tss['und'][0].value);
					} else {
						// load values from node
						if($('#effluent-standard-values input').prop('disabled')){
							$('#effluent-standard-values input').attr('disabled',false);
						}
						
						if($('#edit-effl-submit').hasClass('hidden')){
							$('#edit-effl-submit').removeClass('hidden');
						}
						$('#edit-field-cod').val((!nodeCOD) ?  'N/A' : nodeCOD);
						$('#edit-field-bod5').val((!nodeBOD5) ?  'N/A' : nodeBOD5);
						$('#edit-field-totn').val((!nodeTotN) ?  'N/A' : nodeTotN);
						$('#edit-field-totp').val((!nodeTotP) ?  'N/A' : nodeTotP);
						$('#edit-field-tss').val((!nodeTSS) ?  'N/A' : nodeTSS);
					}
				}
			}
			
			// alter project input field types
			if($('body.page-node-add-project, body.page-node-edit.node-type-project, body.page-dashboard').length > 0) {
				$('#edit-field-population-und-0-value').attr('type','number');
				$('#edit-field-discount-rate-und-0-value').attr('type','number');
				$('#edit-field-ci-cost-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('type','number');
				$('#edit-field-exchange-rate-to-usd-und-0-value').attr('step',0.01);
				/*$('#edit-field-cod').attr('type','number');
				$('#edit-field-cod').attr('step',0.01);
				$('#edit-field-bod5').attr('type','number');
				$('#edit-field-bod5').attr('step',0.01);
				$('#edit-field-totn').attr('type','number');
				$('#edit-field-totn').attr('step',0.01);
				$('#edit-field-totp').attr('type','number');
				$('#edit-field-totp').attr('step',0.01);
				$('#edit-field-tss').attr('type','number');
				$('#edit-field-tss').attr('step',0.01);*/
				

				/*$('#project-node-form').ready(function(){
					// load default value on form ready
					//loadExchangeRate($('#edit-field-currency-und').val(),0);
				});*/

				$('#project-node-form-ajax').ready(function(){
					// load default value on form ready
					loadExchangeRate($('#edit-field-currency').val(),0);
				});
				
				if($('#wamex-project-form').length > 0){
					$('#wamex-project-form').ready(function(){
						loadExchangeRate($('#edit-field-currency-und').val(),0);
						loadEffluentStandardAttributes($('#edit-field-effluent-standard')[0].selectedIndex,1);
					});
				}

				$('#reset-exchange-rate').unbind('click').on('click',function(){
					loadExchangeRate($('#edit-field-currency-und').val(),1);
				});
				
				// field_currency behavior
				$('#edit-field-currency-und').unbind('change').change(function(){
					var currencyTermId = $(this).val();
					loadExchangeRate(currencyTermId,0);
				});
				
				// field_effluent_standard behavior
				$('#edit-field-effluent-standard').unbind('change').change(function(){
					var effluentTermIndex = $(this)[0].selectedIndex;
					//console.log('edit effl std'+effluentTermId);
					loadEffluentStandardAttributes(effluentTermIndex,1);
				});
				
				$('#reset-effluent-standard').unbind('click').on('click',function(){
					loadEffluentStandardAttributes($('#edit-field-effluent-standard').val(),1);
				})
				
			}
			
			if($('body.page-node, body.node-type-project').length > 0){
			
				$('#project-effluent-standard').unbind('change').on('change',function(event){
					loadEffluentStandardAttributes($(this)[0].selectedIndex,1);
				});
				
				$('body.node-type-project').ready(function(){
					if($('#project-effluent-standard').length > 0)loadEffluentStandardAttributes($('#project-effluent-standard')[0].selectedIndex,0);
				}); 
				
				/*function showEffluentStandardAttributes(termIndex){
					var termObj = Drupal.settings.taxonomy.effluentStandards[termIndex];
					//console.log(termIndex);
					//console.log(termObj);
					if (termIndex >= 0){
						$('#project-effluent-cod .effluent-value').html((termObj.field_loading_cod.length === 0) ?  'N/A' : termObj.field_loading_cod['und'][0].value);
						$('#project-effluent-bod5 .effluent-value').html((termObj.field_loading_bod5.length === 0) ?  'N/A' : termObj.field_loading_bod5['und'][0].value);
						$('#project-effluent-totn .effluent-value').html((termObj.field_loading_totn.length === 0) ?  'N/A' : termObj.field_loading_totn['und'][0].value);
						$('#project-effluent-totp .effluent-value').html((termObj.field_loading_totp.length === 0) ?  'N/A' : termObj.field_loading_totp['und'][0].value);
						$('#project-effluent-tss .effluent-value').html((termObj.field_loading_tss.length === 0) ?  'N/A' : termObj.field_loading_tss['und'][0].value);
					}
				}*/
				
				function getEffluentStandardAttributes (){
					var effluentStandardAttributes = ($('#edit-field-cod').val() == 'N/A' ? null : $('#edit-field-cod').val()) +'|'+
						($('#edit-field-bod5').val() == 'N/A' ? null : $('#edit-field-bod5').val()) +'|'+
						($('#edit-field-totn').val() == 'N/A' ? null : $('#edit-field-totn').val()) +'|'+
						($('#edit-field-totp').val() == 'N/A' ? null : $('#edit-field-totp').val()) +'|'+
						($('#edit-field-tss').val() == 'N/A' ? null : $('#edit-field-tss').val());
					return effluentStandardAttributes;
				}
				
				function getAverageLoadings() {
					var averageLoadings = $('#ave_adwf').html()+'|'+$('#ave_cod').html()+'|'+$('#ave_bod5').html()+'|'+$('#ave_totn').html()+'|'+$('#ave_totp').html()+'|'+$('#ave_tss').html();
					return averageLoadings;
				}
				
				$('.btn-show-tech').unbind('click').on('click',function(event){
					var viewport = $('#loading-tech-list');
					var ajaxTechList = Drupal.settings.basePath+'get/ajax/loading/technologies';
					viewport.empty().html('Calculating&nbsp;<img src="' + throbberPath + '"/>');
					var avgLoading = getAverageLoadings();
					var stdValues = getEffluentStandardAttributes();
					var techArgs = avgLoading + '&' + stdValues;
					viewport.load(ajaxTechList+'/'+techArgs,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-tech-list');
					});
				});
			
				$('.form-loading-attribute').attr('type','number');
				var throbberPath = Drupal.settings.basePath+'misc/throbber-active.gif"';
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
				
				if($('#wamex-loading-form').length > 0){
					//console.log('wamex-loading-form ready');
					// if new loading has no title, set loading type default values
					if(!$('#wamex-loading-form #edit-title')[0].value){
						var termIndex = $('#edit-field-loading-type')[0].selectedIndex;
						loadLoadingAttributes(termIndex);
					}
				};
				
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
					var rowViewport = $('#loading-form-container');
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/edit/'+nodeId;
					$('#edit-loading-'+nodeId).addClass('disabled');
					$('#delete-loading-'+nodeId).addClass('disabled');
					rowStaticHtml = rowViewport.html(); 
					rowViewport.append('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					rowViewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-form-container');
						$('.edit-loading-cancel').unbind('click').on('click',function(event){
							rowViewport.html(rowStaticHtml);
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
				
				function loadLoadingAttributes(selected){
					var termObj = Drupal.settings.taxonomy.loadingTypes[selected];
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
				}

				$('#edit-field-loading-type').unbind('change').on('change', function(event){
					//console.log($(this).val());
					console.log($('#edit-field-loading-type')[0].selectedIndex);
					var termIndex = $('#edit-field-loading-type')[0].selectedIndex;
					loadLoadingAttributes(termIndex);
				});
				
				function getSumProduct(attributes,weights){
					var sumProduct = 0;
					attributeCount = attributes.length;
					weightCount = weights.length;
					if (attributeCount == weightCount){
						for(var x = 0; x < attributeCount; x++){
							sumProduct += parseFloat(attributes[x].innerHTML)*parseFloat(weights[x].innerHTML)*.01;
						}
					}
					return sumProduct.toFixed(1);
				}
				
				/*if($('#view-project-loadings tbody td.views-field-field-loading-weight a.loading-weight-editable').length > 0){
					$.fn.editable.defaults.mode = 'inline';
					$('#view-project-loadings tbody td.views-field-field-loading-weight a.loading-weight-editable').each(function(index,value){
						//console.log($(this).attr('id') + ' text: ' + $(this).text());
						$('#'+$(this).attr('id')).editable();
						//console.log('index: '+index);
						//console.log(value);
					});
					
				}*/
				
				$('.loading-weight-editable').unbind('click').on('click', function(event){
					//console.log($(this).attr('id'));
					
				});

				$('#view-project-loadings').ready(function(){
					var weight_values = $('#view-project-loadings tbody td.views-field-field-loading-weight span.loading-weight-container');
					//var weight_values = $('#view-project-loadings tbody td.views-field-field-loading-weight a.loading-weight-editable');
					//console.log(weight_values)
					var weight_sum = 0;
					
					weight_values.each(function(){
						weight_sum += parseInt($(this).text());
					});
					$('#tot_weight').html(weight_sum)
				
					var adwf_avg = 0;
					var adwf_values = $('#view-project-loadings tbody td.views-field-field-loading-adwf');
					adwf_avg = getSumProduct(adwf_values,weight_values);
					//console.log('adwf_avg: '+adwf_avg);
					$('#ave_adwf').html(adwf_avg);

					var cod_avg = 0;
					var cod_values = $('#view-project-loadings tbody td.views-field-field-loading-cod');
					cod_avg = getSumProduct(cod_values,weight_values);
					//console.log('cod_avg: '+cod_avg);
					$('#ave_cod').html(cod_avg);

					var bod5_avg = 0;
					var bod5_values = $('#view-project-loadings tbody td.views-field-field-loading-bod5');
					bod5_avg = getSumProduct(bod5_values,weight_values);
					//console.log('bod5_avg: '+cod_avg);
					$('#ave_bod5').html(bod5_avg);

					var totn_avg = 0;
					var totn_values = $('#view-project-loadings tbody td.views-field-field-loading-totn');
					totn_avg = getSumProduct(totn_values,weight_values);
					//console.log('totn_avg: '+totn_avg);
					$('#ave_totn').html(totn_avg);

					var totp_avg = 0;
					var totp_values = $('#view-project-loadings tbody td.views-field-field-loading-totp');
					totp_avg = getSumProduct(totp_values,weight_values);
					//console.log('totp_avg: '+totp_avg);
					$('#ave_totp').html(totp_avg);

					var tss_avg = 0;
					var tss_values = $('#view-project-loadings tbody td.views-field-field-loading-tss');
					tss_avg = getSumProduct(tss_values,weight_values);
					//console.log('tss_avg: '+tss_avg);
					$('#ave_tss').html(tss_avg);

				});
				
			}
			
			if($('body.page-dashboard').length > 0){
				var throbberPath = Drupal.settings.basePath+'misc/throbber-active.gif"';
				var viewport = $('#dashboard-projects-viewport');
				$('#add-project').unbind("click").on('click',function(event){
					//console.log('add new project');
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
					$('#edit-project-'+nodeId).addClass('disabled');
					$('#delete-project-'+nodeId).addClass('disabled');
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
					$('#edit-project-'+nodeId).addClass('disabled');
					$('#delete-project-'+nodeId).addClass('disabled');
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#dashboard-projects-viewport');
					});
				});
				
				$('#cancel-project').unbind("click").on('click',function(event){
					viewport.empty();
					$('.dashboard-edit-project-btn').removeClass('disabled');
					$('.dashboard-delete-project-btn').removeClass('disabled');
					$('#add-project').removeClass('disabled');
					$('#cancel-project').addClass('hidden');
				});
				
				$('#edit-cancel').addClass('btn');
				$('#edit-cancel').addClass('btn-default');
			}

			
		}
	};
}(jQuery));
