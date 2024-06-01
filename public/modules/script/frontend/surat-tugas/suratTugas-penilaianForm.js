$(document).ready(function() {
 	$('input[type=radio][name=kesimpulan]').on('change', function() {
	  switch ($(this).val()) {
	    case '2':
	      $('[name=kesimpulan-dengan-catatan]').removeAttr('disabled');
      	break;
      	default:
      		$('[name=kesimpulan-dengan-catatan]').attr('disabled', 'disabled').val('');
      	break;
	  }
	});
});

function Back() {
  	var url = baseURL +'/suratTugas';
  	return window.location.href = url;
}


function kirimPenilaian(event) {
	var formData = new FormData($('#penilaianKelayakanJudulForm')[0]);
	var valid = true;

	var catatanPenilaianKelayakan = $('[name=catatan-penilaian-kelayakan]');
	catatanPenilaianKelayakan.removeClass('is-invalid');

	var kesimpulan = $('input[name=kesimpulan]:checked');
	kesimpulan.removeClass('is-invalid');

	var kesimpulanDenganCatatan = $('[name=kesimpulan-dengan-catatan]');
	kesimpulanDenganCatatan.removeClass('is-invalid');

	if (catatanPenilaianKelayakan.val() == '') {
		catatanPenilaianKelayakan.addClass('is-invalid');
		valid = false;
	}

	if (kesimpulan.val() == '') {
		kesimpulan.addClass('is-invalid');
		valid = false;
	}

	if (kesimpulan.val() == '2') {
		if (kesimpulanDenganCatatan.val() == '') {
			kesimpulanDenganCatatan.addClass('is-invalid');
			valid = false;
		}
	}

	if (!valid) {
		return false;
	}

	formData.append('dosen_id', $('[name=dosen_id]').val());
	formData.append('mahasiswa_id', $('[name=mahasiswa_id]').val());
	formData.append('uji_kelayakan_id', $('[name=uji_kelayakan_id]').val());
	formData.append('kesimpulan', kesimpulan.val());
	formData.append('kesimpulanDenganCatatan', kesimpulanDenganCatatan.val());

	var url = baseURL + `/suratTugas/insertPenilaian`;

  	$.ajax({
    url: url,
    type: "POST",
    data: formData,
    dataType: "JSON",
    contentType: false,
    cache: false,
    processData: false,
    enctype: 'multipart/form-data',
    beforeSend: function(item) {
    	$('.btn-kirim-penilaian').attr('disabled', 'disabled').text('Loading...');
    },
    success: function(data) {
      switch(data.code) {
        case 201:
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
          	$('#penilaianKelayakanJudulForm')[0].reset();
          	$('[name=kesimpulan-dengan-catatan]').attr('disabled', 'disabled').val('');
            Back();
          });
        break;
        default:
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

      $('.btn-kirim-penilaian').removeAttr('disabled').text('Kirim ke Admin dan Mahasiswa');
    },
    error: function (jqXHR, textStatus, errorThrown) {
    	$('.btn-kirim-penilaian').removeAttr('disabled').text('Kirim ke Admin dan Mahasiswa');
      	throw textStatus;
    }
  });
  return false;

}