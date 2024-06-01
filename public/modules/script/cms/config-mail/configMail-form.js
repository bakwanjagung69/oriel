var save_method;
$(document).ready(function() {
	var id = $('input[name=id]').val();
	if (id !== '') {
		save_method = 'update-data';
		$('.__info').css('display', 'block');
		_getDatas(id);
	} else {
		save_method = 'add-data';
		dataTableMeailCC([]);	
		dataTableSosmed([]);
	}

  	// CKEDITOR.replace('_description');
	$('#_body_email_to').wysihtml5();
	$('#_body_email_received').wysihtml5();

	/** Preview Image */
	$(document).on('click', '#close-preview', function(){ 
	    $('.image-preview').popover('hide');
	    // Hover befor close the preview
	    $('.image-preview').hover(
	        function () {
	           $('.image-preview').popover('show');
	        }, 
	         function () {
	           $('.image-preview').popover('hide');
	        }
	    );    
	});

 	var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:100,
            height:100
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
    /** [END] Preview Image */

    $('input[name=password]').next().click(function(event){
    	if (event.currentTarget.dataset.show == '0') {
    		event.currentTarget.className = 'fa fa-eye-slash';
    		event.currentTarget.dataset.show = 1;
    		event.currentTarget.previousElementSibling.type = 'password';
    	} else {
    		event.currentTarget.className = 'fa fa-eye';
    		event.currentTarget.dataset.show = 0;
    		event.currentTarget.previousElementSibling.type = 'text';
    	}
    	return false;
	});
});

function dataTableMeailCC(dataSet) {
   	$('#__table').DataTable({
        data: dataSet,
        columns: [       
          	{
              "data": "email_cc",
              "orderable": true,
              "className": "details-control",
              render: function (data, type, row, meta) {
              	return data;
              }
          	},                                   
          	{
              "data": "email_cc",
              "orderable": false,
              "className": "dt-center",
              "width": 70,
              render: function (data, type, row, meta) {
                var html = '<div class="btn-group">' +
		                      '<button type="button" class="btn btn-default btn-sm" onclick="DeleteMailCC(\''+row.email_cc+'\');">' +
		                      	'<i class="fa fa-trash" aria-hidden="true"></i>' +
		                      '</button>' +
		                    '</div>';
              return html;
          	}
          }          
        ],
        "lengthMenu": [[5, 15, 50, -1], [5, 15, 50, "All"]]
    });
    return false;
}

function AddMailCC(event) {
	var data = new FormData($('#formID')[0]);

	var emailCC = data.get('email_cc');
	if (emailCC == '') {
		$('input[name=email_cc]').css('border', '1px solid #ff0000');
		return false;
	}

	var __tables = $('#__table').DataTable();
	var json = [{
        "email_cc": emailCC
    }];

	var _listData = __tables.rows().data();

	var _valid = true;
	var _contentText = '';
	for (var i = 0; i < _listData.length; i++) {	
		if (_listData[i].email_cc == '') {
			_contentText = 'Email CC cannot be empty.';
			_valid = false;
		}	
		if (_listData[i].email_cc == emailCC) {
			_contentText = 'Email <b>'+emailCC+'</b> is already on the list.';
			_valid = false;
		}
	}

	if (_valid) {
		__tables.rows.add(json).draw();
		$('input[name=email_cc]').val('').css('border', '1px solid #d2d6de');
	} else {
	  	$.confirm({
           title: 'ATTENTION!',
           content: _contentText,
           type: 'orange',
           typeAnimated: true,
           buttons: {
             	btnOK: {
	               text: 'OK',
	               btnClass: 'btn-orange',
	               action: function(event) {}
	         	}
           	}
     	});
		return false;
	}
	return false;
}

function DeleteMailCC(value) {
	var __tables = $('#__table').DataTable();
	$.confirm({
       title: 'ATTENTION!',
       content: 'Are you sure you want to delete this Email CC?',
       type: 'red',
       typeAnimated: true,
       autoClose: 'Cancel|8000',
       buttons: {
         	btnOK: {
                text: 'OK',
                btnClass: 'btn-red',
                action: function(event) {
               		__tables.rows( function(idx, data, node) {
               			return data.email_cc == value;
			     	}).remove().draw();

           			var _listData = __tables.rows().data();
					if (_listData.length == 0) {
						// $('#btn-save').prop("disabled", true);
					}
                },
         	},
         	Cancel: {
	     	 	text: 'Cancel',
	      		action: function () {}
		    }
       	}
 	});	
    return false;
}

function dataTableSosmed(dataSet) {
   	$('#__tableSosmed').DataTable({
        data: dataSet,
        columns: [       
          	{
              "data": "iconSosmed",
              "orderable": true,
              "className": "dt-center details-control",
              render: function (data, type, row, meta) {
              	return '<i class="fa fa-3x">&#x'+ data +'</i>';
              }
          	},     
          	{
              "data": "sosmedName",
              "orderable": true,
              "className": "details-control",
              render: function (data, type, row, meta) {
              	return data;
              }
          	},     
          	{
              "data": "urlSodmed",
              "orderable": true,
              "className": "details-control",
              render: function (data, type, row, meta) {
              	return data;
              }
          	},                                   
          	{
              "data": "sosmedName",
              "orderable": false,
              "className": "dt-center",
              "width": 70,
              render: function (data, type, row, meta) {
                var html = '<div class="btn-group">' +
		                      '<button type="button" class="btn btn-default btn-sm" onclick="DeleteSosmed(\''+row.sosmedName+'\');">' +
		                      	'<i class="fa fa-trash" aria-hidden="true"></i>' +
		                      '</button>' +
		                    '</div>';
              return html;
          	}
          }          
        ],
        "lengthMenu": [[5, 15, 50, -1], [5, 15, 50, "All"]]
    });
    return false;
}

function AddSosmed(event) {
	var data = new FormData($('#formID')[0]);

	var sosmedName = data.get('sosmedName');
	if (sosmedName == '') {
		$('input[name=sosmedName]').css('border', '1px solid #ff0000');
		return false;
	}

	var urlSodmed = data.get('urlSodmed');
	if (urlSodmed == '') {
		$('input[name=urlSodmed]').css('border', '1px solid #ff0000');
		return false;
	}

	var iconSosmed = data.get('iconSosmed');
	if (iconSosmed == '') {
		$('select[name=iconSosmed]').css('border', '1px solid #ff0000');
		return false;
	}

	var __tables = $('#__tableSosmed').DataTable();
	var json = [{
        "sosmedName": sosmedName,
        "urlSodmed": urlSodmed,
        "iconSosmed": iconSosmed
    }];

	var _listData = __tables.rows().data();

	var _valid = true;
	var _contentText = '';
	for (var i = 0; i < _listData.length; i++) {	
		if (_listData[i].sosmedName == '') {
			_contentText = 'Social Media cannot be empty.';
			_valid = false;
		}	
		if (_listData[i].sosmedName == sosmedName) {
			_contentText = 'Social Media <b>'+sosmedName+'</b> is already on the list.';
			_valid = false;
		}
		if (_listData[i].urlSodmed == '') {
			_contentText = 'URL cannot be empty.';
			_valid = false;
		}	
		if (_listData[i].urlSodmed == urlSodmed) {
			_contentText = 'URL <b>'+urlSodmed+'</b> is already on the list.';
			_valid = false;
		}
		if (_listData[i].iconSosmed == '') {
			_contentText = 'Icon cannot be empty.';
			_valid = false;
		}	
		if (_listData[i].iconSosmed == iconSosmed) {
			_contentText = 'Icon <b>'+iconSosmed+'</b> is already on the list.';
			_valid = false;
		}
	}

	if (_valid) {
		__tables.rows.add(json).draw();
		$('input[name=sosmedName]').val('').css('border', '1px solid #d2d6de');
		$('input[name=urlSodmed]').val('').css('border', '1px solid #d2d6de');
		$('select[name=iconSosmed]').val('').css('border', '1px solid #d2d6de');
	} else {
	  	$.confirm({
           title: 'ATTENTION!',
           content: _contentText,
           type: 'orange',
           typeAnimated: true,
           buttons: {
             	btnOK: {
	               text: 'OK',
	               btnClass: 'btn-orange',
	               action: function(event) {}
	         	}
           	}
     	});
		return false;
	}
	return false;
}

function DeleteSosmed(value) {
	var __tables = $('#__tableSosmed').DataTable();
	$.confirm({
       title: 'ATTENTION!',
       content: 'Are you sure you want to delete this Social Media?',
       type: 'red',
       typeAnimated: true,
       autoClose: 'Cancel|8000',
       buttons: {
         	btnOK: {
                text: 'OK',
                btnClass: 'btn-red',
                action: function(event) {
               		__tables.rows( function(idx, data, node) {
               			return data.sosmedName == value;
			     	}).remove().draw();

           			var _listData = __tables.rows().data();
					if (_listData.length == 0) {
						// $('#btn-save').prop("disabled", true);
					}
                },
         	},
         	Cancel: {
	     	 	text: 'Cancel',
	      		action: function () {}
		    }
       	}
 	});	
    return false;
}



function _getDatas(id = null) {
	var url = baseURL +'/admin/configMail/getdatabyid';

	$.ajax({
      url : url,    
      type: "POST",
      data: {"id" : id},
      dataType: "JSON",
      success: function(data) {
		$('#_body_email_to').val(data.body_email_to);
		$('#_body_email_received').val(data.body_email_received);
     	var jsonMailCC = [];		

	 	setTimeout(function() { 
			$('input[name=main_email]').val(data.main_email);
			$('input[name=email_name]').val(data.email_name);
			$('input[name=body_email_to]').val(data.body_email_to);
			$('input[name=email_received]').val(data.email_received);
			$('input[name=body_email_received]').val(data.body_email_received);
			$('input[name=reply_to_email]').val(data.reply_to_email);
			$('input[name=reply_to_email_name]').val(data.reply_to_email_name);

			$('input[name=charset]').val(data.charset);
			$('input[name=host]').val(data.host);
			$('input[name=mail_type]').val(data.mail_type);
			$('input[name=password]').val(data.password);
			$('input[name=port]').val(data.port);
			$('input[name=protocol]').val(data.protocol);
			$('input[name=subject_email]').val(data.subject_email);
			$('input[name=timeout]').val(data.timeout);
			$('input[name=username]').val(data.username);
			$('select[name=validation]').val(data.validation);
			$('select[name=wordwrap]').val(data.wordwrap);
			$('select[name=status]').val(data.status);

 			var loaderImg =  (baseURL + '/files/loaderImg?loader=loader-image');
 			var urlPicture = (baseURL + '/files/images?q=' + data.logo);

 			lazyLoadImg('loadImg');
 			$('.priview-img').replaceWith('<div class="priview-img"><img class="loadImg" src="'+ loaderImg +'" data-src="' + urlPicture + '" style="width: 50%;height: auto;border-radius: 4px;padding: 10px;border: 1px solid #d2d6de;" /></div>');
	    }, 700);	

	 	setTimeout(function() { 
	    	$("#_body_email_received").data("wysihtml5").editor.setValue(data.body_email_received);
	      	$("#_body_email_to").data("wysihtml5").editor.setValue(data.body_email_to);
    	}, 3000);
     	
     	setTimeout(function() {
     		if (data.email_cc !== '') {
			 	var emailCCList = data.email_cc.split(',');
			 	for (var i = 0; i < emailCCList.length; i++) {
			      	jsonMailCC.push({
				        "email_cc": emailCCList[i]
				    });
			 	}

			 	dataTableMeailCC(jsonMailCC);
     		} else {
     			dataTableMeailCC([]);
     		}

		 	dataTableSosmed(JSON.parse(data.social_media));
     	}, 3200);

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

	var data = new FormData($('#formID')[0]);

	var __tablesMailCC = $('#__table').DataTable();
	var dataTableMainCc = __tablesMailCC.rows().data();
	var listDataEmailCC = [];
	for (var i = 0; i < dataTableMainCc.length; i++) {
		listDataEmailCC.push(dataTableMainCc[i].email_cc);
	}
	data.append('email_cc_list', JSON.stringify(listDataEmailCC));

	var __tableSosmed = $('#__tableSosmed').DataTable();
	var dataTableSosmed = __tableSosmed.rows().data();
	var listDataSosmed = [];
	for (var i = 0; i < dataTableSosmed.length; i++) {
		listDataSosmed.push({
			'iconSosmed' : dataTableSosmed[i].iconSosmed,
			'sosmedName' : dataTableSosmed[i].sosmedName,
			'urlSodmed' : dataTableSosmed[i].urlSodmed
		});
	}
	data.append('sosmed_list', JSON.stringify(listDataSosmed));

	var url;
	if (save_method == 'add-data') {
		url = baseURL + '/admin/configMail/addnewdata';
	} else {
		url = baseURL + '/admin/configMail/updatedata';
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
		               		var url = baseURL +'/admin/configMail';
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
		      case 400:
		      	$('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
			  	$.confirm({
		           title: 'Allowed Files size!',
		           content: data.response,
		           type: 'orange',
		           typeAnimated: true,
		           buttons: {
		             btnSave: {
		               text: 'OK',
		               btnClass: 'btn-orange',
		               action: function(event) {
		               }
	             	},
		           }
	         	});
		      break;
		      case 405:
		      	return;
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
	             	close: function(error) {

	             	}
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
	var url = baseURL +'/admin/configMail';
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
				// if (elementInput[i].name == 'title') {
				// 	var parrentEl = elementInput[i].nextSibling.parentElement;
				// 	$(parrentEl).addClass('has-error');
				// 	valid = false;
				// }
			} else {
				// if (elementInput[i].name == 'title') {
				// 	var parrentEl = elementInput[i].nextSibling.parentElement;
				// 	$(parrentEl).addClass('has-error');
				// 	valid = false;
			}
		}
	}
	return valid;
}