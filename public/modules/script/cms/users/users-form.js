var save_method;
$(document).ready(function() {
	var id = $('input[name=id]').val();
	if (id !== '') {
		save_method = 'update-data';
		$('.__info').css('display', 'block');
		getDataUsers(id);
	} else {
		save_method = 'add-data';
	}

	/** Show and Hide Password */
	$(".reveal").on('click',function() {
	    var $pwd = $(".pwd");
	    if ($pwd.attr('type') === 'password') {
	        $pwd.attr('type', 'text');
	        $($(this)[0].firstElementChild).removeClass('glyphicon-eye-close');
	        $($(this)[0].firstElementChild).addClass('glyphicon-eye-open');
	    } else {
	        $pwd.attr('type', 'password');
	        $($(this)[0].firstElementChild).removeClass('glyphicon-eye-open');
	        $($(this)[0].firstElementChild).addClass('glyphicon-eye-close');
	    }
	});
	/** [END] Show and Hide Password */

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
});

function getDataUsers(id = null) {
	var url = baseURL +'/admin/users/getdatabyid';

	$.ajax({
      url : url,    
      type: "POST",
      data: {"id" : id},
      dataType: "JSON",
      success: function(data) {
	 	setTimeout(function() { 
	 		$('input[name=full_name]').val(data.full_name);
	 		$('input[name=username]').val(data.username);
	 		$('input[name=email]').val(data.email);
	 		$('select[name=status]').val(data.status);
	 		$('select[name=rules]').val(data.rules);
	 		$('input[name=images]').attr("value", data.images);

	 		var loaderImg =  (baseURL + '/files/loaderImg?loader=loader-image');
 			var urlPicture = (baseURL + '/files/images?q=' + data.images);

 			lazyLoadImg('loadImg');
 			$('.priview-img').replaceWith('<div class="priview-img"><img class="loadImg" src="'+ loaderImg +'" data-src="' + urlPicture + '" style="width: 50%;height: auto;border-radius: 4px;padding: 10px;border: 1px solid #d2d6de;" /></div>');
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
		url = baseURL + '/admin/users/addnewdata';
	} else {
		url = baseURL + '/admin/users/updatedata';
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
		               		var url = baseURL +'/admin/users';
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
	var url = baseURL +'/admin/users';
	return window.location.href = url;
}

function Validation() {
	var valid = true;
	var elementInput = $('#formID').find('input, select');

	for (var i = 1; i < elementInput.length; i++) {
		var _el = elementInput[i].localName + '[name='+elementInput[i].name+']';
		var _elVal = elementInput[i].value;
		if (_elVal !== '') {
			if (elementInput[i].name == 'pass') {
				var parrentEl = elementInput[i].nextSibling.parentElement.nextSibling.parentElement;
				$(parrentEl).removeClass('has-error');
			}
			if (elementInput[i].name == 'images') {
				var parrentEl = elementInput[i].nextSibling.parentElement.nextSibling.parentElement;
				$(parrentEl).removeClass('has-error');
			}
			var parrentEl = elementInput[i].nextSibling.parentElement;
			$(parrentEl).removeClass('has-error');
			valid = true;
		}

		if (_elVal == '') {		
			if (save_method == 'update-data') {
				if (elementInput[i].name == 'full_name') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'username') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'email') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'status') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'rules') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
			} else {
				if (elementInput[i].name == 'full_name') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'username') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'email') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'status') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'rules') {
					var parrentEl = elementInput[i].nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'pass') {
					var parrentEl = elementInput[i].nextSibling.parentElement.nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
				if (elementInput[i].name == 'images') {
					var parrentEl = elementInput[i].nextSibling.parentElement.nextSibling.parentElement;
					$(parrentEl).addClass('has-error');
					valid = false;
				}
			}
		}
	}
	return valid;
}