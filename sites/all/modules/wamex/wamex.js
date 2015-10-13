(function ($) {
	
	Drupal.behaviors.wamex = {
		attach: function (context, settings) {
			if($('body.page-dashboard').length > 0){
				//var projectValidatorOptions = ;
				
				$('#wamex-project-form').ready(function(){
					$('#edit-title').trigger('focus');
					$('#wamex-project-form')
					.on('init.form.fv', function (e, data){
						//console.log('init_form_fv');
						data.fv.disableSubmitButtons(true);
					})
					.formValidation({
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
					})
					.formValidation('validate');
				});
			}
		
			if($('body.node-type-project').length > 0){
				$('#wamex-loading-form').ready(function(){
					//$('#edit-title').focus();
					$('#edit-title').trigger('focus');
					//$(this).blur();
					$('#wamex-loading-form')
						.find('[name="field_loading_type"]')
							//.selectpicker()
							.change(function(e) {
								// revalidate the language when it is changed
								$('#wamex-loading-form').formValidation('revalidateField', 'field_loading_type');
							})
							.end()
						.formValidation({
							framework: 'bootstrap',
							/*excluded: ':disabled',*/
							icon: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
							},
							fields: {
								title: {
									validators: {
										notEmpty: {
											message: 'Name required'
										}
									}
								},
								field_loading_type: {
									trigger: 'focus blur',
									validators: {
										notEmpty: {
											message: 'Type required'
										}
									}
								},
								field_loading_weight: {
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
						})
						.formValidation('validate');
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