(function ($) {
	
	Drupal.behaviors.wamex = {
		attach: function (context, settings) {
			if($('body.page-dashboard').length > 0){
				var projectValidatorOptions = {
					feedbackIcons: {
							valid: 'glyphicon glyphicon-ok',
							invalid: 'glyphicon glyphicon-remove',
							validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						'title': {
							trigger: 'focus blur keyup',
							validators: {
								notEmpty: {
									message: 'The project title is required and cannot be empty'
								}
							}
						}
					}
				};
				
				$('#wamex-project-form').ready(function(){
					$('#edit-title').trigger('focus');
					$(this).blur();
					$('#wamex-project-form')
					.on('init.field.bv', function (e, data){
						if(data.field == 'title' && data.element[0].value == "") { 
							data.bv.disableSubmitButtons(true);
						}
					})
					.bootstrapValidator(projectValidatorOptions)
					.on('success.field.bv', function(e, data) {
						console.log('success.field.bv');
						if (data.bv.isValid()) {
							data.bv.disableSubmitButtons(false);
						}
					});
				});
			}
		
			if($('body.node-type-project').length > 0){
				var loadingValidatorOptions = {
						feedbackIcons: {
								valid: 'glyphicon glyphicon-ok',
								invalid: 'glyphicon glyphicon-remove',
								validating: 'glyphicon glyphicon-refresh'
						},
						fields: {
							'title': {
								trigger: 'focus blur keyup',
								validators: {
									notEmpty: {
										message: 'Name required'
									}
								}
							},
							'field_loading_type' : {
								trigger: 'focus blur keyup change',
								validators: {
									greaterThan: {
										value: 0,
										message: 'Type required'
									}
								}
							}
						}
				};
				
				$('#wamex-loading-form').ready(function(){
						$('#edit-title').trigger('focus');
						$(this).blur();
						$('#wamex-loading-form')
						.on('init.form.bv', function (e, data){
							//console.log('loading form ready');
							data.bv.disableSubmitButtons(true);
						})
						.on('init.field.bv', function (e, data){
							if((data.field == 'title' || data.field == 'field_loading_type') && (data.element[0].value == "" || data.element[0].value == "0")) { 
								console.log(data.field + ':')
								console.log(data.element);
								data.bv.disableSubmitButtons(true);
							}
						})
						.bootstrapValidator(loadingValidatorOptions)
						.on('success.field.bv', function(e, data) {
							console.log('success.field.bv');
							console.log(data.field);
							if (data.bv.isValid()) {
								data.bv.disableSubmitButtons(false);
							}
						});
				});
			
			}

		}
		
	};
}(jQuery));