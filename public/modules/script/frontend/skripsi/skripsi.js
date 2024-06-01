$( document ).ready(function() {
	$(".custom-file-input").on("change", function() {
	  var fileName = $(this).val().split("\\").pop();
	  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});

	$('input[name="nim"]').keyup(function(e){
  		if (/\D/g.test(this.value)) {
   	 		this.value = this.value.replace(/\D/g, '');
	  	}
	});

});

function Save() {
	$('.loadersAction').replaceWith('<i class="fa fa-circle-o-notch fa-pulse fa-fw loadersAction"></i>');

  	var nama  = $('input[name=nama]');
  	var judul = $('input[name=judul]'); 
  	var nim   = $('input[name=nim]');
  	var semester   = $('select[name=semester]');
  	var skripsi_files    = $('input[name=skripsi_files]');
  	var surat_tugas_file = $('input[name=surat_tugas_file]');

	var valid = true;
	nama.removeClass('is-invalid');
	judul.removeClass('is-invalid');
	nim.removeClass('is-invalid');
	semester.removeClass('is-invalid');
	skripsi_files.removeClass('is-invalid');
	surat_tugas_file.removeClass('is-invalid');

 	if (nama.val() == '') {
	    $(nama).addClass('is-invalid');
	    valid = false;
  	}

 	if (judul.val() == '') {
	    $(judul).addClass('is-invalid');
	    valid = false;
  	}

 	if (nim.val() == '') {
	    $(nim).addClass('is-invalid');
	    valid = false;
  	}

	if (semester.val() == '') {
	    $(semester).addClass('is-invalid');
	    valid = false;
  	}

 	if (skripsi_files.val() == '') {
	    $(skripsi_files).addClass('is-invalid');
	    valid = false;
  	}

 	if (surat_tugas_file.val() == '') {
	    $(surat_tugas_file).addClass('is-invalid');
	    valid = false;
  	}

  	if (!valid) {
	    $('.loadersAction').replaceWith('<i class="fa fa-floppy-o loadersAction">');
	    return false;
  	}

	var data = new FormData($('#formSkripsi')[0]);
  	var url = baseURL + '/skripsi/addNewData';

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
	           $('.loadersAction').replaceWith('<i class="fa fa-floppy-o loadersAction">');
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
					 	$('#formSkripsi')[0].reset();
	                   	$('.custom-file-label').text('');
	                   	var url = baseURL +'/jadwalSidang';
						window.location.href = url;
					});
            break;
         	case 302:
            	$('.loadersAction').replaceWith('<i class="fa fa-floppy-o loadersAction">');
	          	swal({
				  title: "Pemberitahuan!",
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
	          	$('.loadersAction').replaceWith('<i class="fa fa-floppy-o loadersAction">');
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
	      }
	    },
	    error: function (jqXHR, textStatus, errorThrown) {
	      console.log(textStatus);
	    }
  	});
 	return false;
}