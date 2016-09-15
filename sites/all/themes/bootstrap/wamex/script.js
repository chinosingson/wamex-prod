﻿(function ($) {
	
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
				$('#collapse-project-info, #collapse-loading-list, #collapse-standards, #collapse-tech, #collapse-popeq, #collapse-scenario, #collapse-financial-info, #collapse-retic').unbind('show.bs.collapse').on('show.bs.collapse',function(e){
					//console.log(e.currentTarget.id+' '+e.type);
					//console.log(e);
					var collapseElement = $('#'+e.currentTarget.id);
					var togglerElement = collapseElement.prev().find('a').find('span');
					//console.log(togglerElement);
					toggleArrow(togglerElement[0].id);
				});

				$('#collapse-project-info, #collapse-loading-list, #collapse-standards, #collapse-tech, #collapse-popeq, #collapse-scenario, #collapse-financial-info, #collapse-retic').unbind('hide.bs.collapse').on('hide.bs.collapse',function(e){
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

				function getScenarioRowValues(scenarioRadioId){
					if(scenarioRadioId){
						var radioIdTokens = scenarioRadioId.split("-");
						var scenarioId = radioIdTokens[2];
						return {
              "name": $("#scenario-title-label-"+scenarioId)[0].innerHTML,
              "land": $("#field_scenario_req_land_hidden_"+scenarioId)[0].innerHTML,
							"chem":$("#field_scenario_req_chem_hidden_"+scenarioId)[0].innerHTML,
							"energy":$("#field_scenario_req_energy_hidden_"+scenarioId)[0].innerHTML,
							"om":$("#field_scenario_om_hidden_"+scenarioId)[0].innerHTML,
							"shock":$("#field_scenario_shock_hidden_"+scenarioId)[0].innerHTML,
							"flow":$("#field_scenario_flow_hidden_"+scenarioId)[0].innerHTML,
							"toxic":$("#field_scenario_toxic_hidden_"+scenarioId)[0].innerHTML,
              "sludge":$("#field_scenario_sludge_hidden_"+scenarioId)[0].innerHTML};
					} else {
						return {};
					}
				}
				
				// set COD as default parameter
				$('#edit-popeq-parameter--2').attr('checked',true);
        Drupal.settings.node.values.popeq = {'param': 'cod'};
				//$('#edit-popeq-parameter--2').click();
				//console.log($('#edit-popeq-parameter--2').value);
				//console.log($('[name="popeq_parameter"]').value);
				//console.log()

				function showTechnologies(popeqValue) {
					//console.log('showTechnologies');
					/*if (popeqValue) console.log(popeqValue);
					// else console.log('popeqValue = wala');*/
					var techListViewport = $('#loading-tech-list');
					var ajaxTechList = Drupal.settings.basePath+'get/ajax/loading/technologies';
					//$('#collapse-tech').collapse('show');
					techListViewport.empty().html('Calculating&nbsp;<img src="' + throbberPath + '"/>');
					var avgLoading = getAverageLoadings();
					//console.log(avgLoading);
					var stdValues = getEffluentStandardAttributes();
					//console.log($('.scenario-radio:checked').attr('id'));
					var scenarioValues = getScenarioValues($('.scenario-radio:checked').attr('id'));
					//$('#collapse-scenario').collapse('toggle');
					var landCost = Drupal.settings.node.values.field_land_cost;
					var exchRate = Drupal.settings.node.values.field_exchange_rate;
					var currCode = Drupal.settings.node.values.field_currency_code;
          var nodeID = Drupal.settings.node.values.nid;
					//var designHorizon = $('#tech-design-horizon').val();
					//var inflationRate = $('#tech-inflation-rate').val();
					var techArgs = [avgLoading,stdValues,popeqValue,scenarioValues,landCost,exchRate,currCode,nodeID].join('&');
					//var techArgs = avgLoading + '&' + stdValues+ '&' +popeqValue + '&' + scenarioValues + '&' + landCost + '&' + exchRate;// x|y|z&a|b|c
					//if (scenarioValues !="") techArgs + '&' +scenarioValues;
					//console.log(techArgs);
          var loadingListViewport = $('#loading-view-container > #loading-list-container > div');
          //console.log(loadingListViewport.innerHTML);
          //if(!loadingListViewport.innerHTML){
          //  loadingListViewport.empty().html('<div id="loading-no-loading" class="alert alert-info">There are no Wastewater Characterisations. Click on the <i>Add</i> button to create one or more profiles.</div>');
          //}
					if (avgLoading.length > 0){
						//$('#collapse-tech').collapse('show');
            //techListViewport.empty().html('<div>123<br/></div>');
						techListViewport.load(ajaxTechList+'/'+techArgs,'ajax=1',function(){
							Drupal.attachBehaviors('#loading-tech-list');
						});
					} else {
						techListViewport.empty().html('<div id="tech-no-loading" class="alert alert-info">There are no Wastewater Characterisations. Click on the <i>Add</i> button in the Wastewater Characterisations panel to create one or more profiles.</div>');
					}
          //console.log(Drupal.settings.node.values);
				}
        
        function getTechArgs() {
          var popeqParamName = $('input[name="popeq_parameter"]:checked','#wamex-project-popeq-form').val();
          var techTdSelector = 'td.popeq-totpe-'+popeqParamName; 
          var popeqValue = $(techTdSelector)[0].innerHTML.replace(/,/g,"");
					var avgLoading = getAverageLoadings();
					//console.log(avgLoading);
					var stdValues = getEffluentStandardAttributes();
					//console.log($('.scenario-radio:checked').attr('id'));
					var scenarioValues = getScenarioValues($('.scenario-radio:checked').attr('id'));
					//$('#collapse-scenario').collapse('toggle');
					var landCost = Drupal.settings.node.values.field_land_cost;
					var exchRate = Drupal.settings.node.values.field_exchange_rate;
					var currCode = Drupal.settings.node.values.field_currency_code;
          var nodeID = Drupal.settings.node.values.nid;
          //console.log('nodeID = '+nodeID);
					//var designHorizon = $('#tech-design-horizon').val();
					//var inflationRate = $('#tech-inflation-rate').val();
					var techArgs = [avgLoading,stdValues,popeqValue,scenarioValues,landCost,exchRate,currCode,nodeID].join('&');
          //console.log(techArgs);
          return techArgs;
        }
        
				// LOADING
				$('.form-loading-attribute').attr('type','number');
				var throbberPath = Drupal.settings.basePath+'misc/throbber-active.gif"';
				$('.btn-add-loading').unbind('click').on('click',function(){
					var viewport = $('#loading-form-container');
          //var loadingListViewport = $('#loading-view-container > #loading-list-container > div');
					if($('#cancel-loading').hasClass('hidden')) $('#cancel-loading').removeClass('hidden');
					var btnId = $(this).attr('id');
					var idTokens = btnId.split("-");
					var projectId = idTokens[2];
					var ajaxFormPath = Drupal.settings.basePath+'get/ajax/loading/add/'+projectId;
          //loadingListViewport.empty();
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
					return sumProduct;
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
					$('#ave_adwf').html(adwf_avg.toFixed(1));

					var cod_avg = 0;
					var cod_values = $('#view-project-loadings tbody td.views-field-field-loading-cod');
					cod_avg = getSumProduct(cod_values,weight_values);
					//console.log('cod_avg: '+cod_avg);
					$('#ave_cod').html(cod_avg.toFixed(1));

					var bod5_avg = 0;
					var bod5_values = $('#view-project-loadings tbody td.views-field-field-loading-bod5');
					bod5_avg = getSumProduct(bod5_values,weight_values);
					//console.log('bod5_avg: '+cod_avg);
					$('#ave_bod5').html(bod5_avg.toFixed(1));

					var totn_avg = 0;
					var totn_values = $('#view-project-loadings tbody td.views-field-field-loading-totn');
					totn_avg = getSumProduct(totn_values,weight_values);
					//console.log('totn_avg: '+totn_avg);
					$('#ave_totn').html(totn_avg.toFixed(1));

					var totp_avg = 0;
					var totp_values = $('#view-project-loadings tbody td.views-field-field-loading-totp');
					totp_avg = getSumProduct(totp_values,weight_values);
					//console.log('totp_avg: '+totp_avg);
					$('#ave_totp').html(totp_avg.toFixed(1));

					var tss_avg = 0;
					var tss_values = $('#view-project-loadings tbody td.views-field-field-loading-tss');
					tss_avg = getSumProduct(tss_values,weight_values);
					//console.log('tss_avg: '+tss_avg);
					$('#ave_tss').html(tss_avg.toFixed(1));

          Drupal.settings.node.values.loading = { 
            'adwf_avg': adwf_avg, 
            'cod_avg': cod_avg, 
            'bod5_avg': bod5_avg, 
            'totn_avg': totn_avg, 
            'totp_avg': totp_avg, 
            'tss_avg': adwf_avg 
          };
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
					paramText[1] = "N/A"; // None
					paramText[2] = "V. Low";  // Low
					paramText[3] = "Low"; // Medium
					paramText[4] = "High"; // High
					paramText[5] = "V. High"; // V. High
					
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
          console.log($('.scenario-radio:checked').attr('id'));
					var radioId = $(this).attr('id');
					var idTokens = radioId.split("-");
					var scenarioNodeId = idTokens[2];
					var rowId = '#scenario-row-'+scenarioNodeId;
          Drupal.settings.node.values.scenario = { 'selected': scenarioNodeId };
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
					$('#edit-field-land-area').attr('type','number');
					$('#edit-field-population-density').attr('type','number');
					$('#edit-field-pipe-length').attr('type','number');

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
          
          Drupal.settings.node.values.popeq['pe_cod']= pe_cod;
          Drupal.settings.node.values.popeq['pe_bod5']= pe_bod5;
          Drupal.settings.node.values.popeq['pe_totn']= pe_totn;
          Drupal.settings.node.values.popeq['pe_totp']= pe_totp;
          Drupal.settings.node.values.popeq['pe_tss']= pe_tss;
          Drupal.settings.node.values.popeq['pe_volc']= pe_volc;
          Drupal.settings.node.values.popeq['totpe_cod']= totpe_cod;
          Drupal.settings.node.values.popeq['totpe_bod5']= totpe_bod5;
          Drupal.settings.node.values.popeq['totpe_totn']= totpe_totn;
          Drupal.settings.node.values.popeq['totpe_totp']= totpe_totp;
          Drupal.settings.node.values.popeq['totpe_tss']= totpe_tss;
          Drupal.settings.node.values.popeq['totpe_volc']= totpe_volc;
          Drupal.settings.node.values.popeq['tot_flow']= totflow;
					$('.popeq-totflow').text(totflow.format(2,'.',','));
					
				}

				// on change of any of the PopEq Parameters
				$('#table-popeq input.popeq-parameter').unbind('change').unbind('keyup').unbind('blur').on('change keyup blur', function(e){
					var selectedParam = this.id.split("-")[2];
					console.log(selectedParam);
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
          console.log(totPopEqDisplay);
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
          // always set currently selected popeq parameter
          Drupal.settings.node.values.popeq.param = selPar;
				}
				
        // POPEQ
        // column highlighting behaviors
        
				$('#table-popeq input.popeq-parameter').unbind('blur').on('blur',function(){
          // activate unhighlight when blurring away from a person load equivalent input
					var selectedParam = this.id.split("-")[2];
					highlightColumn(selectedParam,'unhighlight');
				});

				$('#table-popeq input.popeq-parameter').unbind('focus').unbind('click').on('focus click',function(e) {
          // activate unhighlight when focusing or clicking on a person load equivalent input
					var selectedParam = this.id.split("-")[2];
					highlightColumn(selectedParam,'highlight');
				});
				
				
				$('[name="popeq_parameter"]').unbind('blur').on('blur',function(){
          // activate unhighlight when blurring away from a popeq radio button
					var selectedParam = this.value; //.split("-")[2];
					highlightColumn(selectedParam,'unhighlight');
				});
				
				$('[name="popeq_parameter"]').unbind('focus').unbind('click').on('focus click',function(e){
          // activate unhighlight when focusing or clicking on a popeq radio button
					var selectedParam = this.value;
					highlightColumn(selectedParam,'highlight');
				});

				$('body.node-type-project, body.page-project-edit').ready(function(event){
					if($('#project-effluent-standard').length > 0){ 
						loadEffluentStandardAttributes($('#project-effluent-standard')[0].selectedIndex,0);
					}

          
					//$('#collapse-tech').collapse('show');
				// TECHNOLOGIES
					$('#loading-tech-list',context).once('display',function(){
						//var popeqParamName = $('input[name="popeq_parameter"]:checked','#wamex-project-popeq-form').val();
						//var techTdSelector = 'td.popeq-totpe-'+popeqParamName; 
            //console.log('#loading-tech-list loaded. calculating suitable technologies');
            var ajaxTechHref = $('.btn-ajax-tech').attr('href');
            var _techArgs = getTechArgs();
            $('.btn-ajax-tech').attr('href', ajaxTechHref+'/'+_techArgs);
            //console.log($('.btn-ajax-tech').attr('href'));
						//showTechnologies($(techTdSelector)[0].innerHTML.replace(/,/g,""));
					});
				}); 
				
        function getPopeqValue() {
          var popeqParamName = $('input[name="popeq_parameter"]:checked','#wamex-project-popeq-form').val();
          var techTdSelector = 'td.popeq-totpe-'+popeqParamName;
          return ($(techTdSelector)[0].innerHTML.replace(/,/g,""));
        }  
				// TECHNOLOGIES
				$('.btn-show-tech').unbind('click').on('click',function(event){
						//var popeqParamName2 = $('input[name="popeq_parameter"]:checked','#wamex-project-popeq-form').val();
						//var techTdSelector2 = 'td.popeq-totpe-'+popeqParamName2;
            console.log(Drupal.settings.node.values);
						showTechnologies(getPopeqValue());
				});
        
        $('.btn-make-json').unbind('click').on('click', function(event){
          console.log(Drupal.settings);
          var projectObj = new Object();
          
          //projectObj['general']['title'] = Drupal.settings.node.values.title;
          var scenarioValuesObj = getScenarioRowValues($('.scenario-radio:checked').attr('id'));
          
          projectObj = {
            "general" : {
              "title"    : Drupal.settings.node.values.title,
              "author"   : Drupal.settings.node.values.field_author,
              "location" : Drupal.settings.node.values.field_location,
              "population" : parseInt(Drupal.settings.node.values.field_population),
              "description" : Drupal.settings.node.values.body
            },
            "financial" : {
              "currency" : Drupal.settings.node.values.field_currency_name,
              "currencyCode" : Drupal.settings.node.values.field_currency_code,
              "exchangeRate" : parseFloat(Drupal.settings.node.values.field_exchange_rate),
              "landCost" : parseFloat(Drupal.settings.node.values.field_land_cost)
            },
            "wastewater": {
              "loadings" : [],
              "averageLoadings" : {
                "adwf": parseFloat(adwf_avg),
                "cod": parseFloat(cod_avg),
                "bod5": parseFloat(bod5_avg),
                "n": parseFloat(totn_avg),
                "p": parseFloat(totp_avg),
                "tss": parseFloat(tss_avg)
              }
            },
            "standards" : {
              "name" : Drupal.settings.node.values.field_effluent_standard_name,
              "cod"  : parseFloat(Drupal.settings.node.values.field_cod),
              "bod5" : parseFloat(Drupal.settings.node.values.field_bod5),
              "totn" : parseFloat(Drupal.settings.node.values.field_totn),
              "totp" : parseFloat(Drupal.settings.node.values.field_totp),
              "tss"  : parseFloat(Drupal.settings.node.values.field_tss)
            },
            "popeq" : {
              "pol": {
                "cod": parseInt($('#edit-pol-cod').val()),
                "bod5": parseInt($('#edit-pol-bod5').val()),
                "n": parseInt($('#edit-pol-totn').val()),
                "p": parseInt($('#edit-pol-totp').val()),
                "tss": parseInt($('#edit-pol-tss').val()),
                "volC": parseInt($('#edit-pol-volc').val())
              },
              "pe": {
                "cod": pe_cod,
                "bod5": pe_bod5,
                "n": pe_totn,
                "p": pe_totp,
                "tss": pe_tss,
                "volC": pe_volc
              },
              "totalPE": {
                "cod": totpe_cod,
                "bod5": totpe_bod5,
                "n": totpe_totn,
                "p": totpe_totp,
                "tss": totpe_tss,
                "volC": totpe_volc
              },
              "totalFlow": totflow
            },
            "scenarios" : {
              "name": scenarioValuesObj.name,
              "land": scenarioValuesObj.land,
              "chemical": scenarioValuesObj.chem,
              "energy": scenarioValuesObj.energy,
              "om": scenarioValuesObj.om,
              "shock": scenarioValuesObj.shock,
              "flow": scenarioValuesObj.flow,
              "toxic": scenarioValuesObj.toxic,
              "sludge": scenarioValuesObj.sludge
            },
            "technologies" : Drupal.settings.node.values.technologies,
            "reticulation" : {
              "landArea": parseFloat(Drupal.settings.node.values.field_land_area),
              "populationDensity" : parseFloat(Drupal.settings.node.values.field_population_density),
              "typeSewerage": Drupal.settings.node.values.field_sewerage_type,	
              "pipeLength": parseFloat(Drupal.settings.node.values.field_pipe_length),
              "pumps":{
                "6L": 99,
                "12L":99
              },
              "costSewerage":0.99,
              "costSeweragePC":0.99
            }
            
          };
          //projectObj.general.description = Drupal.settings.node.values.body;
          //projectObj.financial.currency = Drupal.settings.node.values.field_currency_name;
          //projectObj.standards.name = Drupal.settings.node.values.field_effluent_standard_name;
          
          console.log(projectObj);
          //console.log(JSON.stringify(projectObj));
          
        });
				
			
				// TECHNOLOGIES
				// financial info variables
				var techFinancialDisplayStatus = true;	// default to displayed
				var techTogglePerCapitaStatus = false;	// default to not displayed
				var objFinancialControl = $('#tech-toggle-fn-attr');
        var objDisplayToggleControl = $('input[type=radio][name=tech-toggle-display]');
				var objFinancialCells = $('#table-loading-tech th.tech-financial-attr, #table-loading-tech td.tech-financial-attr');
        var objEfficiencyCells = $('#table-loading-tech th.tech-ww-attr, #table-loading-tech td.tech-ww-attr');
          objEfficiencyCells.hide();
				var objPCToggleControl;	// per capita toggle control
					objPCToggleControl = $('#tech-toggle-fn-per-capita')
					objPCToggleLabel = $('#label-toggle-per-capita');
				var objPCCells;		// per capita cells
					objPCCells = $('#table-loading-tech td.tech-capex-pc, #table-loading-tech td.tech-opex-pc');
					objPCCells.hide();
				var objPCLabels;
					objPCLabels = $('#table-loading-tech span.tech-financial-attr-pc-label-unit.label-unit');
					objPCLabels.hide();
				var objPECells;
					objPECells = $('#table-loading-tech td.tech-capex-pe, #table-loading-tech td.tech-opex-pe');
					objPECells.show();
				var objPELabels;
					objPELabels = $('#table-loading-tech span.tech-financial-attr-label-unit.label-unit');
					objPELabels.show();
					
				//$('#tech-toggle-ww-attr, #tech-toggle-fn-attr').unbind('click').on('click', function(event){
				objDisplayToggleControl.change(function(){
          //var techDisplayElementName = '
					//$('#table-loading-tech th.tech-'+this.value+'-attr, #table-loading-tech td.tech-'+this.value+'-attr').show();
					if (this.value == 'fn') {
            $('#table-loading-tech th.tech-financial-attr, #table-loading-tech td.tech-financial-attr').show();
            $('#table-loading-tech th.tech-ww-attr, #table-loading-tech td.tech-ww-attr').hide();
            objPCToggleControl.prop('disabled', false);
          } else if (this.value == 'ww'){
            $('#table-loading-tech th.tech-ww-attr, #table-loading-tech td.tech-ww-attr').show();
            $('#table-loading-tech th.tech-financial-attr, #table-loading-tech td.tech-financial-attr').hide();
            objPCCells.hide();
            objPCToggleControl.prop('checked', false);
            objPCToggleControl.prop('disabled', true);
          }
				});

				/*
				var objDesignHorizon;
					objDesignHorizon = $('#tech-design-horizon');
					//objDesignHorizon.attr('type','number');
					//objDesignHorizon.attr('maxlength','2');
				var objInflationRate;
					objInflationRate = $('#tech-inflation-rate');
					//objInflationRate.attr('type','number');
				*/
					
				// enable per capita toggle on initial load
				objPCToggleControl.unbind('click').on('click', function(event){
					objPELabels.toggle();
					objPECells.toggle();
					objPCLabels.toggle();
					objPCCells.toggle();
				});

				// toggle financial info
				/*objFinancialControl.unbind('click').on('click', function(event){
					// financial info headers and cells
					techFinancialDisplayStatus = $(this).prop('checked');
					//console.log('techFinancialDisplayStatus='+techFinancialDisplayStatus)
					// toggle display off Financial Tech Info
					objFinancialCells.toggle(0, function(){
						// if financial cells are displayed
						if (techFinancialDisplayStatus === true){
							// display Per Capita control and label
							objPCToggleControl.show(0,function(){
								$(this).unbind('click').on('click', function(event){
									objPELabels.toggle();
									objPECells.toggle();
									objPCLabels.toggle();
									objPCCells.toggle();
								});
							});
							objPCToggleLabel.show();
							objPELabels.show();
						} else {
							// uncheck toggle per capita checkbox
							objPCToggleControl.prop('checked',false);
							// hide Per Capita control and label
							objPCToggleControl.hide();
							objPCToggleLabel.hide();
							objPCLabels.hide();
							objPCCells.hide();
							$(this).hide();
						}
					});
					
				});*/
				
				// design horizon
				/*
				objDesignHorizon.unbind('click').on('change', function(){
					console.log(objDesignHorizon.val());
				});
				// inflation rate
				objInflationRate.unbind('click').on('change', function(){
					console.log(objInflationRate.val());
				});
				*/
        
        //  TECHNOLOGIES
        //$('.btn-make-ajax').on('click')
        
				
        // RETICULATION
        function reticulationCost(area,density,sewerage,pop,pipe,terrain) {
          var costSewerage = costOfSewerage(getPopeqValue());
          var costSeweragePC = costSewerage/pop;
          //var numPumps6 = 0;
          //var numPumps12 = 0;
          var costPumps = costOfPumps(terrain,pipe,area);
          //console.log(area+'|'+density+'|'+sewerage+'|'+pop+'|'+pipe);
          console.log(costSewerage+'|'+costSeweragePC+'|'+costPumps);
          //'|'+numPumps6+'|'+numPumps12);
          return [costSewerage, costSeweragePC, costPumps];
        }


        var landArea = $('#edit-field-land-area').val();
        var populationDensity = $('#edit-field-population-density').val();
        var sewerageType = $('#edit-field-sewerage-type').val();
        var pipeLength = $('#edit-field-pipe-length').val();
        var terrainType = $('#edit-field-terrain-type').val();
        var reticValues = reticulationCost(landArea,populationDensity,sewerageType,population,pipeLength,terrainType);
        var reticCost = reticValues[0];
        var reticCostPC = reticValues[1];
        var reticCostPumps = reticValues[2];
        //var pumps6 = reticValues[2];
        //var pumps12 = reticValues[3];
        //var pumpCost = costOfPumps(terrainType,pipeLength,landArea);
        $('#retic-cost').text(reticCost.format(2,'.',','));
        $('#retic-cost-per-capita').text(reticCostPC.format(2,'.',','));
        $('#pump-cost').text(reticCostPumps.format(2,'.',','));
        //$('#retic-pump-count-6').text(pumps6);
        //$('#retic-pump-count-12').text(pumps12);
        
        $('#edit-field-land-area, #edit-field-population-density, #edit-field-sewerage-type, #edit-field-terrain-type, #edit-field-pipe-length, input[name="popeq_parameter"]').unbind('change').on('change keyup focus click', function(){
          landArea = $('#edit-field-land-area').val();
          populationDensity = $('#edit-field-population-density').val();
          sewerageType = $('#edit-field-sewerage-type').val();
          pipeLength = $('#edit-field-pipe-length').val();
          terrainType = $('#edit-field-terrain-type').val();
          //console.log(landArea + '|' + populationDensity);
          //console.log('population: '+$('#td-field-population')[0].innerHTML);
          //console.log($('input[name="popeq_parameter"]:checked').val());
          reticValues = reticulationCost(landArea,populationDensity,sewerageType,population,pipeLength,terrainType);
          reticCost = reticValues[0];
          reticCostPC = reticValues[1];
          reticCostPumps = reticValues[2];
          //pumps6 = reticValues[2];
          //pumps12 = reticValues[3];
          //var pumpCost = costOfPumps(terrainType,pipeLength,landArea);
          $('#retic-cost').text(reticCost.format(2,'.',','));
          $('#retic-cost-per-capita').text(reticCostPC.format(2,'.',','));
          $('#pump-cost').text(reticCostPumps.format(2,'.',','));
          //$('#retic-pump-count-6').text(pumps6);
          //$('#retic-pump-count-12').text(pumps12);
          
        });
        
        function costOfSewerage(popeqValue) {
          c1 = 104.53; // currency factor
          //c1 = 0.035; // currency factor
          c2 = 0.7054; // escalation
          return c1*(Math.pow(popeqValue,c2))*Drupal.settings.node.values.field_exchange_rate;
        }
        
        function costOfPumps(terrain,pipeLen,landArea) {   // ADWF!
          //var output = '';
          //console.log('type: '+(terrain));
          
          // step 1: calculate flow (Q)
          var q = Drupal.settings.node.values.loading.adwf_avg*Drupal.settings.node.values.popeq['totpe_'+Drupal.settings.node.values.popeq.param];
          console.log ('q:'+q);
          
          // step 2: determine pump costs based on flow
          
          
          // step 3: calculate minimum pipe length
          var pipeLengthMin = Math.round(Math.sqrt(landArea/Math.PI)*4,0)/1000;
          console.log('pipeLengthMin:'+pipeLengthMin);
		  $('#edit-field-pipe-length').val(pipeLengthMin);
          
          // step 4: calculate number of pumps
          var pumps6 = 0;
		  var pumps12 = 0;
		  var pumpCount = 0;
		  
		  pumpCount = pumpTotal(pipeLengthMin,terrain)
		  pumps6 = pumpCount[0];
		  pumps12 = pumpCount[1];
		  console.log('pumps6: '+pumps6);
		  console.log('pumps12: '+pumps12);
          
          // step 5: calculate total pump cost (USD)
          var cost6 = 10500;
          var cost12 = 13900;
          
          var totCost6 = pumps6*cost6*Drupal.settings.node.values.field_exchange_rate;
          var totCost12 = pumps12*cost12*Drupal.settings.node.values.field_exchange_rate;
          console.log("cost6: "+totCost6);
          console.log("cost12: "+totCost12);
          
          //return [totPumps6,totPumps12,pipeLengthMin,totCost6,totCost12];
          return totCost6+totCost12;
        }
        
        //function getSelectedPopeq() {
        //  return $('');
        //}
        
        
        function pumpTotal(length,terrain){ // type
          var total = 0;
          var p6 = 0; // 6 liters per second pumps
          var p12 = 0; // 12 liters per second pumps
          // number of pumps per 1.6km -- pressurized pumps
		  console.log('terrain: '+terrain);
          switch (terrain) {
            case 'Flat':
              // -- gravity
              //pumps6 = 2;
              //pumps12 = 1;
              p6 = 0;
              p12 = 0;
              break;
            case 'Rolling':
              //p6 = 1; // set to 1 for pipeLength < 1.6km
              // int(pipelen/1.609)+1
              // int(pipelen/1.609)+2
			  p6 = parseInt(length/1.609)+1;
              p12 = 0;
              break;
            case 'Steep':
              // int(pipelen/1.609)+2
              p6 = parseInt(length/1.609)+2;
              p12 = parseInt(length/1.609)+2;
              break;
            default:
              p6 = 2;
              p12 = 1;
          }
          
          //totPumps6 = pumpTotal(pipeLengthMin,6);
          //totPumps12 = pumpTotal(pipeLengthMin,pumps12);
          //console.log("p6: "+p6);
          //console.log("p12: "+p12);
          /*if (count == 0){
            total =  0;
          } else {
            //total =  Math.round(length/1.6*count);
            total =  Math.round((length/1.609)*count);
          }*/
          //return total;
		  return [p6,p12]
        }
        

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
