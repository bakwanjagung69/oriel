var save_method;
$(document).ready(function() {
	var id = $('input[name=uuid]').val();
	if (id !== '') {
		save_method = 'update-data';
		$('.__info').css('display', 'block');
		_getDatas(id);
	} else {
		save_method = 'add-data';
	}

  	CKEDITOR.replace('_message', {height: 400});
  	// $('#_message').wysihtml5();

    $("#_mailTo").emailMultiple({
      placeholder: 'To: Enter Email...',
      id: '_mailTo',
      data: [],
      reset: false,
      fill: false
    });
    $("#_mailCc").emailMultiple({
      placeholder: 'Cc: Enter Email...',
      id: '_mailCc',
      data: [],
      reset: false,
      fill: false
    });
});

function _getDatas(uuid = null) {
	var url = baseURL +'/admin/messages/getDataByUuid';
	$.ajax({
      url : url,    
      type: "POST",
      data: {"uuid" : uuid},
      dataType: "JSON",
      success: function(data) {
	 	setTimeout(function() { 
	      	$('input[name=name]').val(data.name);
	      	$("#_mailTo").emailMultipleUpdate({
		      id: '_mailTo',
		      srcData: [data.email]
		    });
	    }, 500);	
      },
      error: function (jqXHR, textStatus, errorThrown) {
      	console.log(textStatus);
      }
  	});
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

	/** GET MAIL To */
	var mailToArr = [];
	var listMailTo = $('.selected-_mailTo');
	if (listMailTo.length == 0) {
		$('input[name=multi-email-_mailTo]').css('border', '1px solid #f00');
		$.confirm({
           title: 'Attention!',
           content: 'Mailto cannot be empty!',
           type: 'orange',
           typeAnimated: true,
           buttons: {
             btnSave: {
               text: 'OK',
               btnClass: 'btn-orange',
               action: function(event) {
               	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
               }
         	},
           }
     	});
		return false;
	} else {
		$('input[name=multi-email-_mailTo]').css('border', '1px solid #ccc');
		if (listMailTo.length !== 0) {
		  for (var i = 0; i < listMailTo.length; i++) {
		    mailToArr.push(listMailTo[i].innerText.replace("\nx", ""));
		  }
		}
	}
	/** [END] - GET MAIL To */

	/** GET MAIL CC */
	var listMailCC = $('.selected-_mailCc');
	var mailCCArr = [];
	if (listMailCC.length !== 0) {
	  for (var i = 0; i < listMailCC.length; i++) {
	    mailCCArr.push(listMailCC[i].innerText.replace("\nx", ""));
	  }
	}
	/** [END] - GET MAIL CC */

	var data = new FormData($('#formID')[0]);

	data.append('mailToList', mailToArr);
	data.append('mailCcList', mailCCArr);

  	var message = CKEDITOR.instances._message.getData();
   	data.append('message', message);

	var url = baseURL + '/admin/messages/composeMail' + window.location.search;

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
			    $.confirm({
		           title: 'Success!',
		           content: data.response,
		           type: 'green',
		           typeAnimated: true,
		           buttons: {
		             btnSave: {
		               text: 'OK',
		               btnClass: 'btn-green',
		               action: function(event) {
		               		var url = baseURL +'/admin/messages' + window.location.search;
							window.location.href = url;
		               }
	             	},
	             	// close: function(error) {
	             	// 	$('#formID')[0].reset();
	             	// 	$('.image-preview-clear').click();
	             	// }
		           }
	         	});
		      break;
		      case 403:
		      	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
			  	$.confirm({
		           title: 'ATTENTION!',
		           content: data.response,
		           type: 'orange',
		           typeAnimated: true,
		           buttons: {
		             btnSave: {
		               text: 'SETUP',
		               btnClass: 'btn-orange',
		               action: function(event) {
		               		var url = baseURL +'/admin/configMail';
							window.location.href = url;
		               }
	             	},
	             	btnclose: {
						text: 'Close',
						btnClass: 'btn-grey',
						action: function(event) {}
	             	}
		           }
	         	});
		      break;
			  default:
			  	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
			  	$.confirm({
		           title: 'Error!',
		           content: data.response,
		           type: 'red',
		           typeAnimated: true,
		           buttons: {
		             btnSave: {
		               text: 'OK',
		               btnClass: 'btn-red',
		               action: function(event) {
		               }
	             	},
	             	close: function(error) {}
		           }
	         	});
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
	var url = baseURL +'/admin/messages' + window.location.search;
	return window.location.href = url;
}

function Validation() {
	var valid = true;
	var elementInput = $('#formID').find('input, select');

	for (var i = 1; i < elementInput.length; i++) {
		var _el = elementInput[i].localName + '[name='+elementInput[i].name+']';
		var _elVal = elementInput[i].value;

		if (_elVal == '') {		
			if (save_method == 'update-data') {
				if (elementInput[i].name == 'name') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'mailTo') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'subject') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
			} else {
				if (elementInput[i].name == 'name') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'mailTo') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'subject') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}

				if (elementInput[i].name == 'message') {
					var parrentEl = elementInput[i].nextElementSibling.nextElementSibling;
					$(parrentEl).addClass('has-error').css('border-color', '#f00');
					valid = false;
				}
			}
		}
	}
	return valid;
}