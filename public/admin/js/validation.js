var public_vars = public_vars || {};

;(function($, window, undefined){
	
	"use strict";
	
	$(document).ready(function()
	{	  
		if($.isFunction($.fn.validate))
		{
			$("form.validate").each(function(i, el)
			{
				var $this = $(el),
					opts = {
						rules: {},
						messages: {},
						errorElement: 'span',
						errorClass: 'validate-has-error',
						highlight: function (element) {
							$(element).closest('.form-group').addClass('validate-has-error');
						},
						unhighlight: function (element) {
							$(element).closest('.form-group').removeClass('validate-has-error');
						},
						errorPlacement: function (error, element)
						{
							if(element.closest('.has-switch').length)
							{
								error.insertAfter(element.closest('.has-switch'));
							}
							else
							if(element.parent('.checkbox, .radio').length || element.parent('.input-group').length)
							{
								error.insertAfter(element.parent());
							} 
							else 
							{
								error.insertAfter(element);
							}
						}
					},
					$fields = $this.find('[data-validate]');
				
					
				$fields.each(function(j, el2)
				{
					var $field = $(el2),
						name = $field.attr('name'),
						validate = attrDefault($field, 'validate', '').toString(),
						_validate = validate.split(',');
					
					for(var k in _validate)
					{
						var rule = _validate[k],
							params,
							message;
						
						if(typeof opts['rules'][name] == 'undefined')
						{
							opts['rules'][name] = {};
							opts['messages'][name] = {};
						}
						
						if($.inArray(rule, ['required', 'url', 'email', 'number', 'date', 'creditcard']) != -1)
						{
							opts['rules'][name][rule] = true;
							
							message = $field.data('message-' + rule);
							
							if(message)
							{
								opts['messages'][name][rule] = message;
							}
						}
						// Parameter Value (#1 parameter)
						else 
						if(params = rule.match(/(\w+)\[(.*?)\]/i))
						{
							if($.inArray(params[1], ['min', 'max', 'minlength', 'maxlength', 'equalTo']) != -1)
							{
								opts['rules'][name][params[1]] = params[2];
								
							
								message = $field.data('message-' + params[1]);
								
								if(message)
								{
									opts['messages'][name][params[1]] = message;
								}
							}
						}
					}
				});
				
				$this.validate(opts);
			});
		} 	 
	}); 
})(jQuery, window);

 
var sm_duration = .2,
	sm_transition_delay = 150;

function attrDefault($el, data_var, default_val)
{
	if(typeof $el.data(data_var) != 'undefined')
	{
		return $el.data(data_var);
	}
	
	return default_val;
} 