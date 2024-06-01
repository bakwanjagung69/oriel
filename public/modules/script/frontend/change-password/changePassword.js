var save_method;
$(document).ready(function() {
	var id = $('input[name=id]').val();
	showPassword('showPassLama', 'pwdLama');
	showPassword('showPassBaru', 'pwdBaru');
	showPassword('showPassKonfirmasi', 'pwdKonfirmasi');
});

function showPassword(elemenBtnClassName, elementInputClassName) {
	/** Show and Hide Password */
	$('.' + elemenBtnClassName).on('click',function() {
	    var $pwd = $("." + elementInputClassName);
	    if ($pwd.attr('type') === 'password') {
	        $pwd.attr('type', 'text');
	        $($(this)[0].firstElementChild).removeClass('fa-eye-slash');
	        $($(this)[0].firstElementChild).addClass('fa-eye');
	    } else {
	        $pwd.attr('type', 'password');
	        $($(this)[0].firstElementChild).removeClass('fa-eye');
	        $($(this)[0].firstElementChild).addClass('fa-eye-slash');
	    }
	});
	/** [END] Show and Hide Password */

	return false;
}

function Save(event) {
	$('.loaders').replaceWith('<i class="fa fa-spinner fa-pulse fa-fw loaders"></i>');
	var __valid = Validation();
	if (!__valid) {
		setTimeout(function() { 
			$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');			
		}, 400);
		return false;
	}

	var data = new FormData($('#formID')[0]);
	var url;
	url = baseURL + '/changePassword/update';

	var password_baru = data.get("password_baru");
	var password_konfirmasi = data.get("password_konfirmasi");
	$('input[name=password_baru], input[name=password_konfirmasi]').removeClass('is-invalid');

	if (parseInt(password_baru) !== parseInt(password_konfirmasi)) {
		$('input[name=password_baru], input[name=password_konfirmasi]').addClass('is-invalid');
		$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
	  	swal({
		  title: "Oops!",
		  content: {
		      element: 'div',
		      attributes: {
		        innerHTML: `Password Baru atau Password Konfirmasi tidak sesuai!`,
		      },
		    },
		  html: true,
		  icon: "warning",
		  closeOnClickOutside: false,
		}).then((value) => {});
		return false;
	}


	$.ajax({
		url: url,
		type: "POST",
		data: data,
		dataType: "JSON",
		contentType: false,
		cache: false,
		processData: false,
		success: function(data) {
			switch(data.code) {
			  case 201:
			  	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
			  	swal({
				  	title: 'Success',
				  	content: {
				      element: 'div',
				      attributes: {
				        innerHTML: `${data.response}`,
				      },
				    },
				  	html: true,
				  	icon: "success",
				  	closeOnClickOutside: false,
				  	ok: {
				      text: "OK",
				      value: "action-ok",
				    },
					}).then((value) => {
						$('#formID')[0].reset();
					 	var url = baseURL +'/changePassword';
						window.location.href = url;
					});
		      break;
		      case 302:
				  	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
					  	swal({
						  title: "Oops!",
						  content: {
						      element: 'div',
						      attributes: {
						        innerHTML: `${data.response}`,
						      },
						    },
						  html: true,
						  icon: "warning",
						  closeOnClickOutside: false,
						}).then((value) => {});
		      break;
			  default:
			  	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
			  	swal({
				  title: "Error!",
				  content: {
				      element: 'div',
				      attributes: {
				        innerHTML: `${data.response}`,
				      },
				    },
				  html: true,
				  icon: "error",
				  closeOnClickOutside: false,
				}).then((value) => {});
			  break;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(textStatus);
		}
  	});
  	return false;
}

function Back() {
	var url = baseURL +'/changePassword';
	return window.location.href = url;
}

function Validation() {
	var valid = true;
	var elementInput = $('#formID').find('input, select');

	for (var i = 1; i < elementInput.length; i++) {
		var _el = elementInput[i].localName + '[name='+elementInput[i].name+']';
		var _elVal = elementInput[i].value;
		if (_elVal !== '') {
			var parrentEl = elementInput[i];
			$(parrentEl).removeClass('is-invalid');
			valid = true;
		}

		if (_elVal == '') {		
			if (save_method == 'update-data') {
				if (elementInput[i].name == 'password_lama') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'password_baru') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'password_konfirmasi') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
			} else {
				if (elementInput[i].name == 'password_lama') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'password_baru') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'password_konfirmasi') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
			}
		}
	}
	return valid;
}