(function ($) {
	
	Drupal.behaviors.wamex = {
		attach: function (context, settings) {
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
				$('#edit-title').focus();
				$('#wamex-project-form').bootstrapValidator(projectValidatorOptions)
				.on('success.field.bv', function(e, data) {
						if (data.bv.isValid()) {
								data.bv.disableSubmitButtons(false);
						}
				});
			});
		}
	};
}(jQuery));