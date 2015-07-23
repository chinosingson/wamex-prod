// We define a function that takes one parameter named $.
(function ($) {
	
	Drupal.behaviors.display = {
		attach: function (context, settings) {
			//console.log('hello!');
			// alter project input field types
			$('#edit-field-population-und-0-value').attr('type','number');
			$('#edit-field-discount-rate-und-0-value').attr('type','number');
			$('#edit-field-ci-cost-und-0-value').attr('type','number');
			$('#edit-field-exchange-rate-to-usd-und-0-value').attr('type','number');
			
			// currency info pre-load
			$('#edit-field-currency-und').change(function(){
				console.log($(this).val());
			});
		}
	};
}(jQuery));
