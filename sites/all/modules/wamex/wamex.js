(function ($) {
	
	Drupal.behaviors.wamex = {
		attach: function (context, settings) {
			if($('body.page-dashboard').length > 0){
				var projectValidatorOptions = {
					framework: 'bootstrap',
					icon: {
							valid: 'glyphicon glyphicon-ok',
							invalid: 'glyphicon glyphicon-remove',
							validating: 'glyphicon glyphicon-refresh'
					},
					fields: {
						title: {
							trigger: 'focus blur keyup',
							validators: {
								notEmpty: {
									message: 'The project title is required and cannot be empty.'
								}
							}
						}
					}
				};
				
				$('#wamex-project-form').ready(function(){
					$('#edit-title').trigger('focus');
					$('#wamex-project-form')
					.on('init.form.fv', function (e, data){
						console.log('init_form_fv');
						data.fv.disableSubmitButtons(true);
					})
					.formValidation(projectValidatorOptions);
				});
			}
		
			if($('body.node-type-project').length > 0){
				$('#wamex-loading-form').ready(function(){
					var loadingValidatorOptions = {
							framework: 'bootstrap',
							icon: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
							},
							fields: {
								title: {
									trigger: 'focus keyup',
									validators: {
										notEmpty: {
											message: 'Name required'
										}
									}
								},
								field_loading_type : {
									trigger: 'focus change',
									validators: {
										greaterThan: {
											value: 0,
											inclusive: false,
											message: 'Type required'
										}
									}
								},
								field_loading_weight : {
									trigger: 'focus keyup',
									validators: {
										between: {
											min: 1,
											max: 100,
											inclusive: true,
											message: 'Must be 1-100'
										}
									}
								}
							}
					};
					
					$('#edit-title').trigger('focus');
					//$(this).blur();
					$('#wamex-loading-form')
					.on('init.form.fv', function (e, data){
						console.log('init.form.fv');
						data.fv.disableSubmitButtons(true);
					})
					/*.on('init.field.bv', function (e, data){
						if((data.field == 'title' || data.field == 'field_loading_type') && (data.element[0].value == "" || data.element[0].value == "0")) { 
							console.log(data.field + ':')
							console.log(data.element);
							data.bv.disableSubmitButtons(true);
						}
					})*/
					.formValidation(loadingValidatorOptions);
					/*.on('success.field.bv', function(e, data) {
						console.log('success.field.bv');
						console.log(data.field);
						if (data.bv.isValid()) {
							data.bv.disableSubmitButtons(false);
						}
					});*/
				});
			
			}

		}
		
	};
}(jQuery));