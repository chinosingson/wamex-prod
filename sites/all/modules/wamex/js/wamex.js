(function ($) {

	Drupal.behaviors.wamex = {
		attach: function (context, settings) {
			if($('body.page-dashboard, body.page-project-edit').length > 0){
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
								validating: 'glyphicon glyphicon-refresh',
						},
						fields: {
							title: {
								trigger: 'focus blur keyup',
								validators: {
									notEmpty: {
										message: 'The project title is required and cannot be empty.',
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
										numeric : {
											message : 'Must be a number',
											thousandsSeparator : '',
											decimalSeparator : '.',
										},
										greaterThan: {
											value : 0,
											inclusive : false,
											message : 'Must be greater than zero (0)',
										},
										callback: {
											message : 'Total % must not exceed 100',
											callback : function (value, validator, $field){
												var loadingNIDform = $('#wamex-loading-form input[name=nid]');
												var weight_values = $('#view-project-loadings tbody td.views-field-field-loading-weight span.loading-weight-container');
												//var weight_values = $('#view-project-loadings tbody td.views-field-field-loading-weight a.loading-weight-editable');
												var weight_sum = 0;
												weight_values.each(function(){
													if (loadingNIDform.length > 0){
														if($(this).attr('id') == 'loading-weight-'+loadingNIDform[0].value){
															weight_sum += 0;
														} else {
															weight_sum += parseInt($(this).text());
														}
													} else {
														weight_sum += parseInt($(this).text());
													}
												});
												//console.log(weight_sum+parseInt(value));
												// test if the sum of weights (including the current form value) exceeds 100%
												return weight_sum+parseInt(value) <= 100;
											}
										},
									}
								}
							}
						})
						.formValidation('validate')//;
						.on('err.form.fv', function(e) {
							console.log('error!');
						});
				});

				$('#wamex-scenario-form').ready(function(){
					$('#edit-title').trigger('focus');
					$('#wamex-scenario-form')
						.find('[name="title"]')
							.change(function(e){
								$('#wamex-scenario-form').formValidation('revalidateField','title')
							})
							.end()
						.formValidation({
							framework: 'bootstrap',
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
								}
							}
						})
						.formValidation('validate')
						.on('err.form.fv', function(e){
							console.log('error');
						});
				});

        /*$('#wamex-project-retic-form').ready(function(){
          $('#edit-field-pipe-length')
            .formValidation({
							framework: 'bootstrap',
							icon: {
									valid: 'glyphicon glyphicon-ok',
									invalid: 'glyphicon glyphicon-remove',
									validating: 'glyphicon glyphicon-refresh'
							},
							fields: {
								field_pipe_length: {
									validators: {
										notEmpty: {
											message: 'Pipe length required'
										}
									}
								}
							}
            })
						.formValidation('validate')
						.on('err.form.fv', function(e){
							console.log('error');
						});
        });*/

			}

		}

	};
}(jQuery));