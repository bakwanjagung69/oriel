$(document).ready(function() {
	lazyLoadImg('lazy-load-img');

  	$(".custom-file-input-surat-tugas-kelayakan-judul").on("change", function() {
	    var fileName = $(this).val().split("\\").pop();
	    $(this).siblings(".custom-file-label-surat-tugas-kelayakan-judul").addClass("selected").html(fileName);
  	});
});

function Back() {
	var url = baseURL +'/hasilPenilaianJudul';
	return window.location.href = url;
}

function kirimDataPenilaianUjiKelayakanJudulToKaprodi(event) {
	var formData = new FormData($('#formKirimSuratKelayakanJudul')[0]);

	var judul = $('[name=judul]');
	var suratTugasKelayakanJudul = $('[name=surat_tugas_kelayakan_judul]');

	var valid = true;
	judul.removeClass('is-invalid');
	suratTugasKelayakanJudul.removeClass('is-invalid');
	 $(suratTugasKelayakanJudul).next().css('border-color', '#ced4da');


 	if (judul.val() == '') {
	    $(judul).addClass('is-invalid');
	    valid = false;
  	}

 	if (suratTugasKelayakanJudul.prop('files').length == 0) {
	    $(suratTugasKelayakanJudul).next().css('border-color', '#f00');
	    valid = false;
  	}


  	if (!valid) {
	    return false;
  	}

  	formData.append('mahasiswa_id', $('[name=mhsId]').val());
  	formData.append('uji_kelayakan_id', $('[name=ujiKelayakanId]').val());

  	var url = baseURL + `/hasilPenilaianJudul/insertKirimSuratKelayakanJudul`;

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
      $('.upload-surat-kelayakan-judul').attr('disabled', 'disabled').html('Loading...');
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
      $('.upload-surat-kelayakan-judul').removeAttr('disabled').html('Kirim Ke Kaprodi');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('.upload-surat-kelayakan-judul').removeAttr('disabled').html('Kirim Ke Kaprodi');
      console.log(textStatus);
    }
  });
  return false;
}