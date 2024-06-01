var save_method;
$(document).ready(function() {
	var id = $('input[name=id]').val();
	if (id !== '') {
		save_method = 'update-data';
		getDatasemester(id);
	} else {
		save_method = 'add-data';
	}

	/** Input Only Number */
	$('input[name="angkatan"], input[name="dari_tahun"], input[name="sampai_tahun"], input[name="semester"]').keyup(function(e) {
  	if (/\D/g.test(this.value)) {
	    this.value = this.value.replace(/\D/g, '');
	  }
	});
	/** [END] - Input Only Number */

 	$('input[name="dari_tahun"]').datepicker({
        format: "yyyy",
	    orientation: "bottom",
	    language: "{{ app.request.locale }}",
	    keyboardNavigation: false,
	    viewMode: "years",
	    minViewMode: "years",
	    autoclose: true,
        onSelect: function(dateText, inst) {},
        onChangeMonthYear: function(year, month, inst) {},
    }).on('change', function(e){
        var yearsPlus1 = (parseInt(e.target.value) + 1);
        $('input[name="sampai_tahun"]').val(yearsPlus1);
    })

	$('input[name="sampai_tahun"]').datepicker({
        format: "yyyy",
	    orientation: "bottom",
	    language: "{{ app.request.locale }}",
	    keyboardNavigation: false,
	    viewMode: "years",
	    minViewMode: "years",
	    autoclose: true,
        onSelect: function(dateText, inst) {},
        onChangeMonthYear: function(year, month, inst) {},
    });

});

function addOneYear(date) {
  date.setFullYear(date.getFullYear() + 1);
  return date;
}

function getDatasemester(id = null) {
	var url = baseURL +'/semester/getdatabyid';

	$.ajax({
      url : url,    
      type: "POST",
      data: {"id" : id},
      dataType: "JSON",
      success: function(data) {
      	console.log(data);
	 	setTimeout(function() { 
	 		$('input[name=angkatan]').val(data.angkatan);
	 		$('input[name=dari_tahun]').val(data.dari_tahun);
	 		$('input[name=sampai_tahun]').val(data.sampai_tahun);
	 		$('input[name=semester]').val(data.semester);
	 		$('[name=status]').val(data.status).trigger('change');
	    }, 700);	

      },
      error: function (jqXHR, textStatus, errorThrown) {
      	console.log(textStatus);
      }
  	});
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
	if (save_method == 'add-data') {
		url = baseURL + '/semester/addnewdata';
	} else {
		url = baseURL + '/semester/updatedata';
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
					 	var url = baseURL +'/semester';
						window.location.href = url;
					});
		      break;
		      case 405:
		      	return;
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
	var url = baseURL +'/semester';
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
				if (elementInput[i].name == 'angkatan') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'dari_tahun') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'sampai_tahun') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'semester') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'status') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
			} else {
				if (elementInput[i].name == 'angkatan') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'dari_tahun') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'sampai_tahun') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'semester') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
				if (elementInput[i].name == 'status') {
					var parrentEl = elementInput[i];
					$(parrentEl).addClass('is-invalid');
					valid = false;
				}
			}
		}
	}
	return valid;
}