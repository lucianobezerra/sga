/**
  *  jQuery Validarw Plugin
  * Copyright (c)  2010  F&aacute;brica de Software
  * Dual licensed under the MIT and GPL licenses.
  * Author: Valdirene Neves Júnior <valdirene@inf.ceulp.edu.br>
  * Dependencies – jquery http://jquery.com/
  * Version: 0.1.1
  */

jQuery.fn.extend({
	validate: function(settings) { 
		var defaults  = {
			errorClass: 'error',
			validClass: 'valid',
			messages: {
				required: "Por favor, preencha este campo.",
				email: "Por favor, digite um e-mail v&aacute;lido.",
				url: "Por favor, digite uma URL v&aacute;lida.",
				date: "Por favor, digite uma data v&aacute;lida (dd/mm/aaaa).",
				number: "Por favor, digite apenas números.",
				equalTo: "Por favor, indique o mesmo valor novamente.",
				accept: "Por favor, indique um valor com uma extens&atilde;o v&aacute;lida.",
				maxlength: "Por favor, n&atilde;o insira mais que {0} caracteres.",
				minlength: "Por favor, n&atilde;o insira menos que {0} caracteres.",
				rangelength: "Por favor, insira um valor entre {0} e {1} caracteres.",
				range: "Por favor, insira um valor entre {0} e {1}.",
				max: "Por favor, indique um valor inferior ou igual a {0}.",
				min: "Por favor, indique um valor maior ou igual a {0}.",
				higherToday: "Por favor, digite uma data maior que hoje",
				dateHigher: "Por favor, digite uma data maior que a data anterior"
			},
			tooltip: {
				opacity: '1',
				color: "#9C2F2F",
				background: "#F79982",
				border: "solid 1px #9C2F2F",
				width: "auto",
				padding: "3px"
			}
		}
		var options = jQuery.extend(defaults, settings);
		
		var findBy = ".required, .email, .url, .date, .number, [equalTo], [maxlength], [minlength], [rangelength], [range], [max], [min], .higherToday, [dateHigher]";
		
		//CORPO DO PLUGIN
		var $this = this;
		
		$(this).find(findBy)
		.each(function(i) {
			// adiocinando eventos onBlur, onKeypress e onChange
			addEvents(this);
		});
		
		function single(object) {
			return check(object);
		}
		function removeTooltip(object, options) {
			var tooltip = $(object).next();
			if(tooltip.hasClass('fsw-tooltip'))
			{
				tooltip.remove();
				
				$(object).removeClass(options.errorClass).addClass(options.validClass);
			}
		}
		function renderTooltip(object, options, message) {
			var tooltip = $(object).next();

			// Se o próximo elemento n&atilde;o for da classe "fsw-tooltip" ele pega, caso contr&aacute;rio ele cria uma instância
			if(!tooltip.hasClass('fsw-tooltip'))
			{
				tooltip = $('<div></div>')
							.css({
								position: 'absolute',
								zIndex: 5000,
								display: 'none',
								paddingBottom: '14px',
								background: 'url(seta.png) left bottom no-repeat'
							})
							.addClass('fsw-tooltip')
							.append(
								$('<div></div>')
								.css(options.tooltip)
							)
							.insertAfter(object);
			}
			
			tooltip.find('div').html(message);

			
			// Remova a classe "valid" e adiciona a classe "error"
			$(object).removeClass(options.validClass)
			.addClass(options.errorClass)
			.hover(function () {
					if($(object).hasClass(options.errorClass))
					{
						// Mostra a tooltip quando o mouse estiver encima
						$(tooltip).show()
						.css({
							top: $(object).position().top - $(tooltip).height() - 14,
							left: $(object).position().left + $(object).width()
						});;
						//Adiciona um evento pra quando mexer o mouse

					}
				},
				function () {
					$(tooltip).hide();
				}
			)
			addEvents(object);
		}

		function check(object)
		{
			var valid = true;
			var value = $(object).val();
			var message = $(object).attr('title');
			
			if($(object).hasClass('required'))
			{
				if($(object).attr('type') == 'radio' || $(object).attr('type') == 'checkbox')
				{
					if($($this).find('[name='+$(object).attr('name')+']:checked').length == 0)
					{
						message = options.messages.required;
						valid =  false;
					}
				}
				
				else if($(object).val().length < 1) 
				{
					message = options.messages.required;
					valid =  false;
				} 
			}
			if($(object).hasClass('email') && valid)
			{
				if(!/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value)) 
				{
					message = options.messages.email;
					valid =  false;
				} 
			}
			else if($(object).hasClass('url') && valid)
			{
				if(!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value)) 
				{
					message = options.messages.email;
					valid =  false;
				} 
			}
			else if($(object).hasClass('date') && valid)
			{
				if(!/^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/\d{4}$/.test(value))
				{
					message = options.messages.date;
					valid =  false;
				}
			}
			else if($(object).hasClass('number') && valid)
			{
				if(!/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value))
				{
					message = options.messages.number;
					valid =  false;
				}
			}
			
			
			if($(object).attr('equalTo') !== undefined && valid)
			{
				if($(object).val() != $('#'+ $(object).attr('equalTo')).val())
				{
					message = options.messages.equalTo;
					valid =  false;
				}
			}
			
			if($(object).attr('maxlength') > 0 && valid)
			{
				if($(object).val().length >=  $(object).attr('maxlength'))
				{
					message = options.messages.maxlength.replace('{0}', $(object).attr('maxlength'));
					valid =  false;
				}
			}

			if($(object).attr('minlength') !== undefined && valid)
			{
				if($(object).val().length <= $(object).attr('minlength'))
				{
					message = options.messages.minlength.replace('{0}', $(object).attr('minlength'));
					valid =  false;
				}
			}
			
			if($(object).attr('rangelength') !== undefined && valid)
			{
				var numbers = $(object).attr('rangelength').split(',');
				if($(object).val().length < numbers[0] || $(object).val().length > numbers[1])
				{
					message = options.messages.rangelength.replace('{0}', numbers[0]).replace('{1}', numbers[1]);
					valid =  false;
				}
			}
			
			if($(object).attr('range') !== undefined && valid)
			{
				var numbers = $(object).attr('range').split(',');
				if($(object).val() < numbers[0] || $(object).val() > numbers[1])
				{
					message = options.messages.range.replace('{0}', numbers[0]).replace('{1}', numbers[1]);
					valid =  false;
				}
			}
			
			if($(object).attr('min') !== undefined && valid)
			{
				if($(object).val() < $(object).attr('min'))
				{
					message = options.messages.min.replace('{0}', $(object).attr('min'));
					valid =  false;
				}
			}
			
			if($(object).attr('max') !== undefined && valid)
			{
				if($(object).val() >  $(object).attr('max'))
				{
					message = options.messages.max.replace('{0}', $(object).attr('max'));
					valid =  false;
				}
			}
			
			if($(object).attr('dateHigher') !== undefined && valid)
			{
				var dateStart	= new Date();
				var dateEnd		= new Date();

				var dStart	= $('#'+ $(object).attr('dateHigher')).val().split('/');
				dateStart.setFullYear(dStart[2], dStart[1]-1, dStart[0]);

				var dEnd	= $(object).val().split('/');
				dateEnd.setFullYear(dEnd[2], dEnd[1]-1, dEnd[0]);


				if (dateEnd <= dateStart)
				{
					message = options.messages.dateHigher.replace('{0}', $(object).attr('max'));
					valid =  false;
				}
			}
			
			if($(object).hasClass('higherToday') && valid)
			{
				var today	= new Date();
				var myDate	= new Date();

				var dateStart = $(object).val().split('/');
				myDate.setFullYear(dateStart[2], dateStart[1]-1, dateStart[0]);

				if (myDate <= today)
				{
					message = options.messages.higherToday.replace('{0}', $(object).attr('max'));
					valid =  false;
				}
			}
			
			
			if(!valid)
			{
				renderTooltip(object, options, message);
			}
			else
			{
				removeTooltip(object, options);
			}
			return valid;
		}
		function addEvents(object)
		{
			return $(object)
			.blur(function() {
				single(object);
			})
			.change(function() {
				single(object);
			});
		}
		return {
			checkAll: function() {
				var valid = true;
				$($this).find(findBy)
				.each(function(i) 
				{
					var is = check(this);
					if(!is)
						valid = false;
				});
				return valid;
			}
		};
	}
});
