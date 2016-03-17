(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			Number.prototype.format = function(c, d, t){
			var n = this, 
					c = isNaN(c = Math.abs(c)) ? 2 : c, 
					d = d == undefined ? "." : d, 
					t = t == undefined ? "," : t, 
					s = n < 0 ? "-" : "", 
					i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
					j = (j = i.length) > 3 ? j % 3 : 0;
				 return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
			 };
 
			function loadExchangeRate(termId,reset) {
				//console.log('loadExchangeRate');
				// get exchange rate from json-encoded taxonomy term
				// currency info pre-load
				var currencyTerms = Drupal.settings.taxonomy.currency;
				if (currencyTerms[termId]){
					var exchRate = currencyTerms[termId].field_exchange_rate['und'][0].value;
					//var nodeExchRate = Drupal.settings.node.values.field_exchange_rate_to_usd;
					//console.log('exchRate: ' + exchRate);
					//console.log('nodeExchRate: ' + nodeExchRate);
					//console.log($('#edit-field-exchange-rate-to-usd-und-0-value').attr('value'));
					
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
				//console.log(termIndex);
				//console.log(Drupal.settings.taxonomy.effluentStandards);
				var termObj = Drupal.settings.taxonomy.effluentStandards[termIndex];
				var nodeEffluentStandard = Drupal.settings.node.values.field_effluent_standard;
				var nodeCOD = Drupal.settings.node.values.field_cod;
				var nodeBOD5 = Drupal.settings.node.values.field_bod5;
				var nodeTotN = Drupal.settings.node.values.field_totn;
				var nodeTotP = Drupal.settings.node.values.field_totp;
				var nodeTSS = Drupal.settings.node.values.field_tss;
				if(termObj){
					//console.log(termObj);
					if(termObj.name != 'Custom'){
						// load values from js
						if(!$('#effluent-standard-values input').prop('disabled')){
							$('#effluent-standard-values input').attr('disabled',true);
						}
						/*if(!$('#edit-effl-submit').hasClass('hidden')){
							$('#edit-effl-submit').addClass('hidden');
						}*/
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
						
						/*if($('#edit-effl-submit').hasClass('hidden')){
							$('#edit-effl-submit').removeClass('hidden');
						}*/
						$('#edit-field-cod').val((!nodeCOD) ?  'N/A' : nodeCOD);
						$('#edit-field-bod5').val((!nodeBOD5) ?  'N/A' : nodeBOD5);
						$('#edit-field-totn').val((!nodeTotN) ?  'N/A' : nodeTotN);
						$('#edit-field-totp').val((!nodeTotP) ?  'N/A' : nodeTotP);
						$('#edit-field-tss').val((!nodeTSS) ?  'N/A' : nodeTSS);
					}
				}
			}
			
			// alter project input field types
			if($('body.page-node-add-project, body.page-node-edit.node-type-project, body.page-dashboard, body.page-project-edit').length > 0) {
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

				/*$('#project-node-form-ajax').ready(function(){
					// load default value on form ready
					loadExchangeRate($('#edit-field-currency').val(),0);
				});*/
				
				$('#cancel-project').unbind('click').on('click',function(event){
					//console.log('cancel-project');
					//console.log($('#wamex-project-form').find('input[name="nid"]')[0].value);
					//console.log(Drupal.settings.basePath+'node/'+$('#wamex-project-form').find('input[name="nid"]')[0].value);
					// redirect back to the node page
					window.location.replace(Drupal.settings.basePath+'node/'+$('#wamex-project-form').find('input[name="nid"]')[0].value);
				});
				
				if($('#wamex-project-form').length > 0){
					$('#wamex-project-form').ready(function(){
						//console.log($('#edit-field-effluent-standard')[0].selectedIndex);
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
					//console.log(currencyTermId);
					loadExchangeRate(currencyTermId,1);
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
			
			if($('body.page-node, body.node-type-project, body.page-project-edit').length > 0){
				//console.log('here');
				$('#project-effluent-standard, #edit-field-effluent-standard').unbind('change').on('change',function(event){
					loadEffluentStandardAttributes($(this)[0].selectedIndex,1);
				});
				
				$('#table-loading-tech').removeClass('table');
				
				// toggle expand/collapse arrows on sidebar collapse
				$('#collapse-project-info, #collapse-loading-list, #collapse-standards, #collapse-tech, #collapse-popeq, #collapse-scenario').unbind('show.bs.collapse').on('show.bs.collapse',function(e){
					//console.log(e.currentTarget.id+' '+e.type);
					//console.log(e);
					var collapseElement = $('#'+e.currentTarget.id);
					var togglerElement = collapseElement.prev().find('a').find('span');
					//console.log(togglerElement);
					toggleArrow(togglerElement[0].id);
				});

				$('#collapse-project-info, #collapse-loading-list, #collapse-standards, #collapse-tech, #collapse-popeq, #collapse-scenario').unbind('hide.bs.collapse').on('hide.bs.collapse',function(e){
					//console.log(e.currentTarget.id+' '+e.type);
					//console.log(e);
					var collapseElement = $('#'+e.currentTarget.id);
					var togglerElement = collapseElement.prev().find('a').find('span');
					//console.log(togglerElement);
					toggleArrow(togglerElement[0].id);
				});

				function toggleArrow(togglerId){
					//console.log(togglerId);
					//var togglerId = event.currentTarget.id;
					var togglerElement = $('#'+togglerId);
					if (togglerElement.hasClass('glyphicon-chevron-down')){
						//console.log('DOWN!');
						//togglerElement.switchClass('glyphicon-chevron-down','glyphicon-chevron-up',1000);
						togglerElement.removeClass('glyphicon-chevron-down');
						togglerElement.addClass('glyphicon-chevron-up');
					} else if(togglerElement.hasClass('glyphicon-chevron-up')){
						//console.log('UP!');
						//togglerElement.switchClass('glyphicon-chevron-up','glyphicon-chevron-down',1000);
						togglerElement.removeClass('glyphicon-chevron-up');
						togglerElement.addClass('glyphicon-chevron-down');
					}
				};

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
				
				function getEffluentStandardAttributes() {
					var effluentStandardAttributes = ($('#edit-field-cod').val() == 'N/A' ? -1 : $('#edit-field-cod').val()) +'|'+
						($('#edit-field-bod5').val() == 'N/A' ? -1 : $('#edit-field-bod5').val()) +'|'+
						($('#edit-field-totn').val() == 'N/A' ? -1 : $('#edit-field-totn').val()) +'|'+
						($('#edit-field-totp').val() == 'N/A' ? -1 : $('#edit-field-totp').val()) +'|'+
						($('#edit-field-tss').val() == 'N/A' ? -1 : $('#edit-field-tss').val());
						//console.log("efflAttr:"+effluentStandardAttributes);
					return effluentStandardAttributes;
				}
				
				function getAverageLoadings() {
					var averageLoadings = $('#ave_adwf').html()+'|'+$('#ave_cod').html()+'|'+$('#ave_bod5').html()+'|'+$('#ave_totn').html()+'|'+$('#ave_totp').html()+'|'+$('#ave_tss').html();
					//console.log($('#ave_adwf').html());
					if($('#ave_adwf').length > 0){
						//console.log("load:"+averageLoadings);
						return averageLoadings;
					}
					else {
						return false;
					}
				}
				
				function getScenarioValues(scenarioRadioId){
					if(scenarioRadioId){
						var radioIdTokens = scenarioRadioId.split("-");
						var scenarioId = radioIdTokens[2];
						return $("#field_scenario_req_land_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_req_chem_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_req_energy_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_om_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_shock_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_flow_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_toxic_hidden_"+scenarioId)[0].innerHTML+"|"+
							$("#field_scenario_sludge_hidden_"+scenarioId)[0].innerHTML;
					} else {
						return "";
					}
				}
				
				// set COD as default parameter
				$('#edit-popeq-parameter--2').attr('checked',true);
				//$('#edit-popeq-parameter--2').click();
				//console.log($('#edit-popeq-parameter--2').value);
				//console.log($('[name="popeq_parameter"]').value);
				//console.log()

				function showTechnologies(popeqValue) {
					//console.log('showTechnologies');
					/*if (popeqValue) console.log(popeqValue);
					// else console.log('popeqValue = wala');*/
					var viewport = $('#loading-tech-list');
					var ajaxTechList = Drupal.settings.basePath+'get/ajax/loading/technologies';
					//$('#collapse-tech').collapse('show');
					viewport.empty().html('Calculating&nbsp;<img src="' + throbberPath + '"/>');
					var avgLoading = getAverageLoadings();
					//console.log(avgLoading);
					var stdValues = getEffluentStandardAttributes();
					//console.log($('.scenario-radio:checked').attr('id'));
					var scenarioValues = getScenarioValues($('.scenario-radio:checked').attr('id'));
					//$('#collapse-scenario').collapse('toggle');
					var techArgs = avgLoading + '&' + stdValues+ '&' +popeqValue + '&' + scenarioValues; // x|y|z&a|b|c
					//if (scenarioValues !="") techArgs + '&' +scenarioValues;
					//console.log(techArgs);
					if (avgLoading.length > 0){
						viewport.load(ajaxTechList+'/'+techArgs,'ajax=1',function(){
							Drupal.attachBehaviors('#loading-tech-list');
						});
					} else {
						viewport.empty().html('There are no Wastewater Characterisations. Click on <i>Add Loading</i> above to create one or more profiles.');
					}
				}

				// LOADING
				$('.form-loading-attribute').attr('type','number');
				var throbberPath = Drupal.settings.basePath+'misc/throbber-active.gif"';
				$('.btn-add-loading').unbind('click').on('click',function(){
					var viewport = $('#loading-form-container');
					if($('#cancel-loading').hasClass('hidden')) $('#cancel-loading').removeClass('hidden');
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var projectId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/add/'+projectId;
					viewport.empty().html('Retrieving form <img src="' + throbberPath + '" />');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-form-container');
					});
				});
				
				function loadLoadingAttributes(selected){
					var termObj = Drupal.settings.taxonomy.loadingTypes[selected];
					if (selected >= 0){
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

				if($('#wamex-loading-form').length > 0){
					// if new loading has no title, set loading type default values
					if(!$('#wamex-loading-form #edit-title')[0].value){
						var termIndex = $('#edit-field-loading-type')[0].selectedIndex;
						loadLoadingAttributes(termIndex);
					}
				};
				
				// LOADING
				// delete loading button action
				$('.project-delete-loading-btn').unbind('click').on('click',function(event){
					var viewport = $('#loading-form-container');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var loadingNodeId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/delete/'+loadingNodeId;
					$('#edit-loading-'+loadingNodeId).addClass('disabled');
					$('#delete-loading-'+loadingNodeId).addClass('disabled');
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#loading-form-container');
					});
				});
				
				
				// LOADING
				// edit loading button action
				var rowStaticHtml = '';
				$('.project-edit-loading-btn').unbind('click').on('click',function(event){
					if($('#edit-loading-cancel').hasClass('hidden')) $('#edit-loading-cancel').removeClass('hidden');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var loadingNodeId = idTokens[2];
					var rowViewport = $('#loading-form-container');
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/edit/'+loadingNodeId;
					
					$('#edit-loading-'+loadingNodeId).addClass('disabled');
					$('#delete-loading-'+loadingNodeId).addClass('disabled');
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
				
				
				// LOADING
				// cancel edit loading button action
				$('#edit-loading-cancel').unbind("click").on('click',function(event){
					var viewport = $('#loading-form-container');
					viewport.empty();
					$('.project-edit-loading-btn').removeClass('disabled');
					$('.project-delete-loading-btn').removeClass('disabled');
					$('.btn-add-loading').removeClass('disabled');
					$('#edit-loading-cancel').addClass('hidden');
				});
				
				$('#edit-cancel').addClass('btn');
				$('#edit-cancel').addClass('btn-default');
				
				// LOADING
				// edit loading type dropdown action
				$('#edit-field-loading-type').unbind('change').on('change', function(event){
					//console.log($(this).val());
					//console.log($('#edit-field-loading-type')[0].selectedIndex);
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

				//$('#view-project-loadings').ready(function(){
				if($('#view-project-loadings').length > 0){
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

				}
				
				
				// POPEQ
				function getTotPolV(attributes,weights){
					var adwfs = $('#view-project-loadings tbody td.views-field-field-loading-adwf');
					//console.log(adwfs);
					var sumProduct = 0;
					attributeCount = attributes.length;
					if($('#view-project-loadings').length > 0){
						weightCount = weights.length;
						if (attributeCount == weightCount){
							for(var x = 0; x < attributeCount; x++){
								sumProduct += adwfs[x].innerHTML*parseFloat(attributes[x].innerHTML)*parseFloat(weights[x].innerHTML)*.00001;
							}
						}
					} 
					return sumProduct;
				}
				
				// SCENARIO
				// add a scenario
				$('.btn-add-scenario').unbind('click').on('click',function(){
					//console.log('ADD SCENARIO');
					var viewport = $('#scenario-form-container');
					//if($('#cancel-loading').hasClass('hidden')) $('#cancel-loading').removeClass('hidden');
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var projectId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/scenario/add/'+projectId;
					viewport.empty().html('Retrieving form <img src="' + throbberPath + '" />');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#scenario-form-container');
					});
				});
				

				// SCENARIO
				// when a scenario parameter is changed
				$('.form-scenario-param').attr('type','range');
				$('.form-scenario-param').attr('orient','vertical');
				$('.form-scenario-param').removeAttr('maxlength');
				$('.form-scenario-param').removeClass('form-control');
				
				function displayParamLevel(paramValue){
					// display scenario parameter level in words
					var paramText = Array();
					paramText[1] = "N/A";
					paramText[2] = "V. Low";
					paramText[3] = "Low";
					paramText[4] = "High";
					paramText[5] = "V. High";
					
					return paramText[paramValue];
				}
				
				// SCENARIO
				// display parameter values on form load
				$('#wamex-scenario-form').ready(function(e){
					$('#edit-field-scenario-req-land-value-display').html(displayParamLevel($('#edit-field-scenario-req-land').val()));
					$('#edit-field-scenario-req-chem-value-display').html(displayParamLevel($('#edit-field-scenario-req-chem').val()));
					$('#edit-field-scenario-req-energy-value-display').html(displayParamLevel($('#edit-field-scenario-req-energy').val()));
					$('#edit-field-scenario-om-value-display').html(displayParamLevel($('#edit-field-scenario-om').val()));
					$('#edit-field-scenario-shock-value-display').html(displayParamLevel($('#edit-field-scenario-shock').val()));
					$('#edit-field-scenario-flow-value-display').html(displayParamLevel($('#edit-field-scenario-flow').val()));
					$('#edit-field-scenario-toxic-value-display').html(displayParamLevel($('#edit-field-scenario-toxic').val()));
					$('#edit-field-scenario-sludge-value-display').html(displayParamLevel($('#edit-field-scenario-sludge').val()));
				});
				
				// SCENARIO
				// load scenario parameter plain-language values
				$('.form-scenario-param').unbind('change').unbind('focus').unbind('click').on('change focus click',function(){
					var displayBoxSelector = "#"+this.id+"-value-display";
					$(displayBoxSelector).html(displayParamLevel($(this).val()));
				});
				
				// scenario
				// delete scenario button action
				$('.project-delete-scenario-btn').unbind('click').on('click',function(event){
					var viewport = $('#scenario-form-container');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var scenarioNodeId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/scenario/delete/'+scenarioNodeId;
					$('#edit-scenario-'+scenarioNodeId).addClass('disabled');
					$('#delete-scenario-'+scenarioNodeId).addClass('disabled');
					viewport.empty().html('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					viewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#scenario-form-container');
					});
				});
				
				// SCENARIO
				// edit scenario button action
				$('.project-edit-scenario-btn').unbind('click').on('click',function(event){
					if($('#edit-scenario-cancel').hasClass('hidden')) $('#edit-scenario-cancel').removeClass('hidden');
					// load the /project/edit/% custom form, and attach ajax behaviors to the container
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var scenarioNodeId = idTokens[2];
					var rowViewport = $('#scenario-form-container');
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/scenario/edit/'+scenarioNodeId;
					
					$('#edit-scenario-'+scenarioNodeId).addClass('disabled');
					$('#delete-scenario-'+scenarioNodeId).addClass('disabled');
					rowStaticHtml = rowViewport.html(); 
					rowViewport.append('<img src="' + throbberPath + '" style="margin-left:50%;"/>');
					rowViewport.load(ajaxFormPath,'ajax=1',function(){
						Drupal.attachBehaviors('#scenario-form-container');
						$('.edit-scenario-cancel').unbind('click').on('click',function(event){
							rowViewport.html(rowStaticHtml);
							Drupal.attachBehaviors($('#scenario-'+nodeId));
							rowStaticHtml = '';
						});
					});
				});
				
				// SCENARIO
				// toggle user scenarios
				$('#user-scenarios-toggle').unbind('click').on('click',function(e){
					console.log('user-scenarios-toggle clicked');
				});
				
				if ($('#user-scenarios-toggle-hidden').length > 0){
					var userScenarios = $('#user-scenarios-toggle-hidden')[0].innerHTML;
					if (userScenarios == 'OFF') $('.scenario-radio').attr('disabled',true);
				}
				//console.log(userScenarios);
				
				// SCENARIO
				// scenario radio button action
				$('.scenario-radio').unbind('click').on('click',function(){
					var radioId = $(this).attr('id');
					var idTokens = radioId.split("-");
					var scenarioNodeId = idTokens[2];
					var rowId = '#scenario-row-'+scenarioNodeId;
				})
				

				$('#edit-scenario-cancel').unbind("click").on('click',function(event){
					var viewport = $('#scenario-form-container');
					viewport.empty();
					$('.project-edit-scenario-btn').removeClass('disabled');
					$('.project-delete-scenario-btn').removeClass('disabled');
					$('.btn-add-scenario').removeClass('disabled');
					$('#edit-loading-cancel').addClass('hidden');
				});

				// calculate Population Equivalent
				function calcPE(param,wts){
					var paramValueSelector = '#view-project-loadings tbody td.views-field-field-loading-'+param;
					var paramValues = $(paramValueSelector);
					var peParamSelector = '#edit-pol-'+param;
					var peParamValue = $(peParamSelector).val();
					//console.log(param);
					var peDisplay = "";
					if(peParamValue > 0){
						if(param!='volc'){
							peDisplay = getTotPolV(paramValues,wts)/peParamValue;
						} else {
							peDisplay = $('#ave_adwf')[0].innerHTML/peParamValue;
						}
					} else {
						peDisplay =  "-";
					}
					//console.log(peDisplay);
					return peDisplay;
				}
				
				if($('body.node-type-project').length > 0){ 
					//var pe_cod = (getTotPolV(cod_values,weight_values)/$('#edit-pol-cod').val());
					var pe_cod = calcPE('cod',weight_values);
					var pe_bod5 = calcPE('bod5',weight_values);
					var pe_totn = calcPE('totn',weight_values);
					var pe_totp = calcPE('totp',weight_values);
					var pe_tss = calcPE('tss',weight_values);
					//var pe_bod5 = (getTotPolV(bod5_values,weight_values)/$('#edit-pol-bod5').val());
					//var pe_totn = (getTotPolV(totn_values,weight_values)/$('#edit-pol-totn').val());
					//var pe_totp = (getTotPolV(totp_values,weight_values)/$('#edit-pol-totp').val());
					//var pe_tss = (getTotPolV(tss_values,weight_values)/$('#edit-pol-tss').val());
					if($('#view-project-loadings').length > 0){
						var pe_volc = (adwf_avg/$('#edit-pol-volc').val());
					} else {
						var pe_volc = 0;
					}
					
					$('#edit-pol-cod').attr('type','number');
					$('#edit-pol-bod5').attr('type','number');
					$('#edit-pol-totn').attr('type','number');
					$('#edit-pol-totp').attr('type','number');
					$('#edit-pol-tss').attr('type','number');
					$('#edit-pol-volc').attr('type','number');

					// set PEs
					$('.popeq-pe-cod').text(pe_cod.toFixed(4));
					$('.popeq-pe-bod5').text(pe_bod5.toFixed(4));
					$('.popeq-pe-totn').text(pe_totn.toFixed(4));
					$('.popeq-pe-totp').text(pe_totp.toFixed(4));
					$('.popeq-pe-tss').text(pe_tss.toFixed(4));
					$('.popeq-pe-volc').text(pe_volc.toFixed(4));

					// set TotPEs
					var population = $('#td-field-population')[0].innerHTML;
					//console.log(population);
					totpe_cod = (pe_cod*population);
					totpe_bod5 = (pe_bod5*population);
					totpe_totn = (pe_totn*population);
					totpe_totp = (pe_totp*population);
					totpe_tss = (pe_tss*population);
					totpe_volc = (pe_volc*population);

					$('.popeq-totpe-cod').text(totpe_cod.format(2,'.',','));
					$('.popeq-totpe-bod5').text(totpe_bod5.format(2,'.',','));
					$('.popeq-totpe-totn').text(totpe_totn.format(2,'.',','));
					$('.popeq-totpe-totp').text(totpe_totp.format(2,'.',','));
					$('.popeq-totpe-tss').text(totpe_tss.format(2,'.',','));
					$('.popeq-totpe-volc').text(totpe_volc.format(2,'.',','));
					
					// set total effluent flow
					var totflow = adwf_avg*population*.001;
					$('.popeq-totflow').text(totflow.format(2,'.',','));
					
				}

				// on change of any of the PopEq Parameters
				$('#table-popeq input.popeq-parameter').unbind('change').unbind('keyup').unbind('blur').on('change keyup blur', function(e){
					var selectedParam = this.id.split("-")[2];
					//console.log(selectedParam);
					var popEq = calcPE(selectedParam,weight_values);
					var popEqDisplay = '';
					var totPopEqDisplay = '';
					if (popEq != '-'){
						popEqDisplay = popEq.toFixed(4);
						//totPopEqDisplay = (popEq*population).toFixed(2);
						totPopEqDisplay = (popEq*population).format(2,'.',',');
					} else {
						popEqDisplay = popEq;
						totPopEqDisplay = '-';
					}
					$('.popeq-pe-'+selectedParam).text(popEqDisplay);
					$('.popeq-totpe-'+selectedParam).text(totPopEqDisplay);
					//calcPE(selectedParam, weight_values);

				});

				function highlightColumn(selPar,hu){
					// if a popeq parameter input form is selected
					// set the corresponding radio button as checked
					var popeqRadioSelector = "td.popeq-parameter-"+selPar+".popeq-"+selPar+" input.popeq-parameter-radio-"+selPar;
					$(popeqRadioSelector).prop("checked", true);
					var colSelector = 'td.col-'+selPar+', th.col-'+selPar;
					if(hu == 'highlight'){
						// add the -selected class
						$(colSelector).addClass('col-'+selPar+'-selected');
					} else if (hu == 'unhighlight') {
						// remove the -selected class
						$(colSelector).removeClass('col-'+selPar+'-selected');
					}
				}
				
				$('#table-popeq input.popeq-parameter').unbind('blur').on('blur',function(){
					var selectedParam = this.id.split("-")[2];
					highlightColumn(selectedParam,'unhighlight');
				});

				$('[name="popeq_parameter"]').unbind('blur').on('blur',function(){
					var selectedParam = this.value; //.split("-")[2];
					highlightColumn(selectedParam,'unhighlight');
				});
				
				$('#table-popeq input.popeq-parameter').unbind('focus').unbind('click').on('focus click',function(e) {
					var selectedParam = this.id.split("-")[2];
					highlightColumn(selectedParam,'highlight');
				});
				
				
				$('[name="popeq_parameter"]').unbind('focus').unbind('click').on('focus click',function(e){
					//console.log(this.value);
					var selectedParam = this.value;
					highlightColumn(selectedParam,'highlight');
				});

				$('body.node-type-project, body.page-project-edit').ready(function(event){
					if($('#project-effluent-standard').length > 0){ 
						loadEffluentStandardAttributes($('#project-effluent-standard')[0].selectedIndex,0);
					}
					$('#loading-tech-list',context).once('display',function(){
						var popeqParamName = $('input[name="popeq_parameter"]:checked','#wamex-project-popeq-form').val();
						var techTdSelector = 'td.popeq-totpe-'+popeqParamName; 
						showTechnologies($(techTdSelector)[0].innerHTML.replace(/,/g,""));
					});
					$('#collapse-tech').collapse('show');
				}); 
				
				// TECHNOLOGIES
				$('.btn-show-tech').unbind('click').on('click',function(event){
					//console.log('btn-show-tech clicked');
					/*if($('#collapse-tech').hasClass('collapse')) {
						$('#collapse-tech').collapse('show');
						//$('#loading-tech-title').click();
					}*/
					//$('#loading-tech-list',context).once('display',function(){
						//console.log();
						var popeqParamName2 = $('input[name="popeq_parameter"]:checked','#wamex-project-popeq-form').val();
						var techTdSelector2 = 'td.popeq-totpe-'+popeqParamName2;
						showTechnologies($(techTdSelector2)[0].innerHTML.replace(/,/g,""));
						//showTechnologies('eto o');
					//});
				});
			
				
				var helpModal = '<div id="section-help-modal" class="custom-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">'
				+'<div class="modal-dialog">'
				+'<div class="modal-content">'
				+'<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
				+'<h4 class="modal-title"></h4>'
				+'</div>'
				+'<div class="modal-body"></div>'
				+'<div class="modal-footer"><button class="btn" data-dismiss="modal">Close</button></div>'
				+'</div>'
				+'</div>'
				+'</div>';
				
				var customHelpModal = $(helpModal);
				$('.section-help').unbind('click').on('click', function(){
					event.preventDefault();
					//console.log($(this).attr('id').split("-")[0]);
					var sectionTitle = $('#'+$(this).attr('id').split("-")[0]+'-title-container h3 a')[0].innerText;
					
					$('.main-container').append(customHelpModal);
					$('#section-help-modal .modal-title').empty().append('Help: '+sectionTitle);
					$('#section-help-modal .modal-body').empty().append('Description of '+ sectionTitle + ' goes here.');
					$('#section-help-modal').show();
					$('#section-help-modal').modal();
				});
				
				var techModal = '<div id="tech-help-modal" class="custom-modal modal fade" tabindex="-1" role="dialog" aria-hidden="true">'
				+'<div class="modal-dialog">'
				+'<div class="modal-content">'
				+'<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
				+'<h4 class="modal-title"></h4>'
				+'</div>'
				+'<div class="modal-body"></div>'
				+'<div class="modal-footer"><button class="btn" data-dismiss="modal">Close</button></div>'
				+'</div>'
				+'</div>'
				+'</div>';
				
				var customTechModal = $(techModal);
				$('.technology-name').unbind('click').on('click',function(event){
					event.preventDefault();
					//console.log($(this).attr('id'));
					// get/ajax/  technology/<tid>
					//.load('get/ajax/technology/'+tid);
					// wastewaterinfo.asia/tech-sheets/tds-003
					$('.main-container').append(customTechModal);
					$('#tech-help-modal .modal-title').empty().append('Technology: '+$(this).text());
					//$('#tech-help-modal .modal-body').empty().append('Description of '+$(this).text() + ' goes here.');
					$('#tech-help-modal .modal-body').empty().load("http://wastewaterinfo.asia/tech-sheets/tds-003");
					$('#tech-help-modal').show();
					$('#tech-help-modal').modal();
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
