/* 				Vérification des champs de formulaires - Olympe 2014 ©

+-------------------------------------------------------------------------------------+
|          							CHAMPS NON VIDES	 	                          |
+-------------------------+-----------------------------------------------------------+
|          TYPE           |                           MOYEN                           |
+-------------------------+-----------------------------------------------------------+
| input[type="text"],     | Ajouter la classe .req pour les champs requis             |
| textarea,               |                                                           |
| input[type="password"]  |                                                           |
+-------------------------+-----------------------------------------------------------+
| input[type="radio"]     | Envelopper tous les choix dans un span.req-radio          |
| input[type="checkbox"]  | Envelopper tous les choix dans un span.req-checkbox       |
+-------------------------+-----------------------------------------------------------+
| select                  | Ajouter la classe .req-select pour tous les champs requis |
| 		                  | (nb : la valeur par défaut doit être -1)	  			  |
+-------------------------+-----------------------------------------------------------+

+-------------------------------------------------------------------------------------+
|          					CHAMPS NOMBRES UNIQUEMENT	 	                          |
+-------------------------------------------------------------------------------------+
Ajouter la classe .num aux champs ne devant contenir que des chiffres.

+-------------------------------------------------------------------------------------+
|          					CHAMPS EMAIL UNIQUEMENT	 	     	                      |
+-------------------------------------------------------------------------------------+
Ajouter la classe .email aux champs ne devant contenir que des emails.
*/

$(function() {

	function newError(msg) {
		var error_head = '<img src="/on/images/icons/notifications/error.png"><br />';
		$("<div class='field_error center'>" + error_head + msg + "</div>").dialog({
			autoOpen: true,
			modal: true,
			width: 400,
			show: {
				effect: "fade",
				duration: 200
			},
			hide: {
				effect: "fade",
				duration: 200
			},
			open: function () {
				$('.ui-widget-overlay').bind('click', function () {
					$(".field_error").dialog('close');
				})
			}
		});
		$(".ui-dialog-titlebar").hide();
	};

	$('.unfield_error, .number_error').css('border-color', '1px solid red !important');

	$('form').submit(function () {
		var form = $(this),
			unfield = 0,
			unfield_text = ' champ obligatoire n\'est pas renseigné.',
			unfield_text_plural = ' champs obligatoires ne sont pas renseignés.',
			badfield = 0,
			badfield_text = ' champ est mal renseigné (chiffres ou email uniquement)',
			badfield_text_plural = ' champs sont mal renseignés (chiffres ou email uniquement)',
			txt = '';

		$('.unfield_error, .number_error').removeClass('unfield_error').removeClass('number_error');

		// NOT EMPTY //
		/* ------------------------------------------------------
			input[type="text"], textarea, input[type="password"] 
		   ------------------------------------------------------ */
		if ($('.req', form).length > 0) {
			$('.req', form).each(function () {
				if ($(this).val() == '') {
					unfield++;
					$(this).addClass('unfield_error');
				}
			});
		}

		/* ------------------------------------------------------
			input[type="radio"]
			All the radio inputs have to be wrapped into 
			span.req-radio
		   ------------------------------------------------------ */
		if ($('.req-radio', form).length > 0) {
			$('.req-radio').each(function () {

				if (($('input[type="radio"]', this).length > 0) && !$('.req-radio input[type="radio"]:checked', form).length) {
					unfield++;
					$(this).addClass('unfield_error');
				}
			});
		}

		/* ------------------------------------------------------
			input[type="checkbox"]
			All the checkbox inputs have to be wrapped into 
			span.req-checkbox
		   ------------------------------------------------------ */
		if ($('.req-checkbox', form).length > 0) {
			$('.req-checkbox').each(function () {

				if (($('input[type="checkbox"]', this).length > 0) && !$('.req-checkbox input[type="checkbox"]:checked', form).length) {
					unfield++;
					$(this).addClass('unfield_error');
				}
			});
		}

		/* ------------------------------------------------------
			select
			Default option value have to be -1
		   ------------------------------------------------------ */
		if ($('.req-select', form).length > 0) {
			$('.req-select', form).each(function () {
				if ($(this).val() == '-1') {
					unfield++;
					$(this).addClass('unfield_error');
				}
			});
		}


		// ONLY NUMBERS //
		if ($('.num', form).length > 0) {
			$('.num').each(function () {
				if (!$.isNumeric($(this).val())) {
					badfield++;
					$(this).addClass('number_error');
				}
			});
		}

		// ONLY EMAIL //
		if ($('.email', form).length > 0) {
			$('.email').each(function () {

				var re = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
				var is_email = re.test($(this).val());
				if (!is_email) {
					badfield++;
					$(this).addClass('number_error');
				}
			});
		}

		// DISPLAY ERROR //
		if (unfield != 0 || badfield != 0) {
			if (unfield > 0) {
				if (unfield == 1) txt = '<strong>' + unfield + '</strong>' + unfield_text;
				else txt = '<strong>' + unfield + '</strong>' + unfield_text_plural;
			}
			if (badfield > 0) {
				if (badfield == 1) txt += '<br /><strong>' + badfield + '</strong>' + badfield_text;
				else txt += '<br /><strong>' + badfield + '</strong>' + badfield_text_plural;
			}

			newError(txt);
			return false;
		}
	});
});