$(document).ready(function() {
	lazyLoadImg('lazy-load-img');
	getDataPenugasanDosenPembimbing();

  $(".custom-file-input-surat-tugas").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label-surat-tugas").addClass("selected").html(fileName);
  });

  /** Checking Disabled BUTTON Approve or not Approve */
  var listEleKesimpulan = $('.keismpulan-flag');
  var btnValid = [];
  for (let i = 0; i < listEleKesimpulan.length; i++) {
    if (listEleKesimpulan[i].dataset.flag == '0') {
      btnValid.push(listEleKesimpulan[i].dataset.flag);
    }
  }

  if (btnValid.length < 3) {
    $('.btn-approve').attr({
      'data-onclick': $('.btn-approve').attr('onclick'),
      'disabled': 'disabled',
    }).removeAttr('onclick');
    $('.btn-not-approve').attr('onclick', $('.btn-not-approve').data('onclick'));
  } else {
    $('.btn-not-approve').attr({
      'data-onclick': $('.btn-not-approve').attr('onclick'),
      'disabled': 'disabled',
    }).removeAttr('onclick');
    $('.btn-approve').attr('onclick', $('.btn-approve').data('onclick'));
  }
  /** [END] - Checking Disabled BUTTON Approve or not Approve */
});

function Back() {
	var url = baseURL +'/hasilPenilaianJudul';
	return window.location.href = url;
}

function notApproveDataHasilPenilaianKelayakanJudul(event, mahasiswa_id, uji_kelayakan_id) {
  var formData = new FormData($('<form>')[0]);
  formData.append('mahasiswa_id', mahasiswa_id);
  formData.append('uji_kelayakan_id', uji_kelayakan_id);

  var url = baseURL + `/hasilPenilaianJudul/NotApprovePenilaianUjiKelayakan`;

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
      $('.btn-approve').attr('disabled', 'disabled').html('<i class="fa fa-circle-o-notch fa-spin fa-fw loadersAction"></i> Loading...');
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
      $('.btn-approven').removeAttr('disabled').html('Approve');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('.btn-approven').removeAttr('disabled').html('Approve');
      console.log(textStatus);
    }
  });
  return false;
}

function approveKeFormKirimSuratTugasKelayakanJudul(event, mahasiswa_id, uji_kelayakan_id) {
  // var url = baseURL + `/hasilPenilaianJudul/kirimSuratKelayakanJudul?mhsId=${mahasiswa_id}&ujiKelayakanId=${uji_kelayakan_id}`;
  // return window.location.href = url;

  var formData = new FormData($('<form>')[0]);
  formData.append('mahasiswa_id', mahasiswa_id);
  formData.append('uji_kelayakan_id', uji_kelayakan_id);

  var url = baseURL + `/hasilPenilaianJudul/ApprovePenilaianUjiKelayakan`;

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
      $('.btn-approve').attr('disabled', 'disabled').html('<i class="fa fa-circle-o-notch fa-spin fa-fw loadersAction"></i> Loading...');
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
      $('.btn-approven').removeAttr('disabled').html('Approve');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('.btn-approven').removeAttr('disabled').html('Approve');
      console.log(textStatus);
    }
  });
  return false;
}

function getDataPenugasanDosenPembimbing() {
  var formulirId = $('[name=ujiKelayakanId]').val();

  var url = baseURL + `/hasilPenilaianJudul/getDataPenugasanDosenPembimbing?formulirId=${formulirId}`;

  $.ajax({
    url : url,    
    type: "GET",
    dataType: "JSON",
    beforeSend: function(item) {

    },
    success: function(data) {
      if (data.length !== 0) {
        var elList = '';
        for (var i = 0; i < data.length; i++) {
          var uriThumnails = (baseURL + '/files/images?q=' + data[i].dosen_images.thumbnail_images);
          var uriImages    = (baseURL + '/files/images?q=' + data[i].dosen_images.images);
          var loaderImg =  (baseURL + '/files/loaderImg?loader=loader-image');

          elList += '<li class="list-li-dosen">' +
            '<div class="parent-section-list-dosen">' +
              '<div class="section-list-item">' +
                '<div>' +
                  '<img class="lazy-load-img avatar-disp" src="'+ loaderImg +'" data-src="'+ uriThumnails +'" width="60" height="60" alt="images" />' +
                '</div>' +
                '<div class="section-list-item-name">'+ data[i].nama_dosen.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                  return letter.toUpperCase();
                }) +'</div>' +
              '</div>';

 				elList += '<div class="section-list-item-input-files">' +
                    '<div class="custom-file">' +
                      '<input type="file" name="surat_tugas_file_to_list_dosen-'+i+'" onchange="trigerFileInput(\'surat_tugas_file_to_list_dosen-'+i+'\', '+i+');" class="custom-file-input-surat-tugas-'+i+'" id="customFileSuratTugas-'+i+'" data-dosenid'+i+'="'+data[i].dosen_id+'" accept="application/pdf">' +
                      '<label class="custom-file-label custom-file-input-surat-tugas-'+i+'" for="customFileSuratTugas-'+i+'">Choose file</label>' +
                    '</div>' +
                    '<small class="text-danger font-italic">Upload file hanya di perboleh kan PDF file.</small>' +
                '</div>';      
                          
            elList += '<div class="section-list-item-jabatan">'+ data[i].type_penugasan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
              }) +'</div>';

              // if (data[i].rules == 4) {
              //   elList += '<div class="section-list-item-btn-delete">' +
              //   '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="DeletePenugasanDosen(\''+ data[i].penugasan_id +'\');" title="Delete data">' +
              //     '<i class="fa fa-trash" aria-hidden="true"></i>' +
              //   '</button>' +
              // '</div>';
              // }

          elList += '</div>' +
          '</li>';
        }
        $('.list-penugasan-dosen-penguji').html(elList);
      } else {
        var elNotFound = '<li class="list-data-empty">' +
            '<div>' +
              'Data Not Found!'
            '</div>' +
        '</li>';
        $('.list-penugasan-dosen-penguji').html(elNotFound);
      }

      lazyLoadImg('lazy-load-img');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });

  return false;
}

function UploadSuratTugasDosenPembimbingAndMahasiswa() {
  var lengthData = $('.list-li-dosen').length;

  var elForm = document.createElement("form");
  elForm.id   = 'formUploadSuratTugasPembimbing';

  var valid = true;

  var suratTugasToMahasiswa = $('[name=surat_tugas_file]');
  $($(suratTugasToMahasiswa).next()).css('border-color', '#ced4da');

  if (suratTugasToMahasiswa.prop('files').length == 0) {
    $($(suratTugasToMahasiswa).next()).css('border-color', '#f00');
    valid = false;
  }

  var formData = new FormData($(elForm)[0]);
  formData.append('ujiKelayakanId', $('[name=ujiKelayakanId]').val());
  formData.append('mhsId', $('[name=mhsId]').val());
  formData.append('surat_tugas_file_to_mahasiswa', $('[name=surat_tugas_file]').prop('files')[0]);

  for (var i = 0; i < lengthData; i++) {
    $($('[name=surat_tugas_file_to_list_dosen-'+i+']').next()).css('border-color', '#ced4da');

    if ($('[name=surat_tugas_file_to_list_dosen-'+i+']').prop('files').length == 0) {
      $($('[name=surat_tugas_file_to_list_dosen-'+i+']').next()).css('border-color', '#f00');
      valid = false;
    } else {
      var dosenID = $('.custom-file-input-surat-tugas-' + i).data('dosenid' + i);
      formData.append('dosenId[]', dosenID);
      formData.append('surat_tugas_file_to_list_dosen[]', $('[name=surat_tugas_file_to_list_dosen-'+i+']').prop('files')[0]);
    }
  }

  if (!valid) {
    return false;
  }

  var url = baseURL + `/hasilPenilaianJudul/addSuratTugasPembimbing`;

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
      $('.upload-surat-tugas-btn').attr('disabled', 'disabled').html('<i class="fa fa-upload loadersAction"></i> Loading...');
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
            $('.custom-file-label-surat-tugas').removeClass("selected").html('Choose file');
            for (var i = 0; i < lengthData; i++) {
              $('.custom-file-input-surat-tugas-' + i).removeClass("selected").html('Choose file');
            }
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
      $('.upload-surat-tugas-btn').removeAttr('disabled').html('<i class="fa fa-upload loadersAction"></i> Upload Surat Tugas');
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('.upload-surat-tugas-btn').removeAttr('disabled').html('<i class="fa fa-upload loadersAction"></i> Upload Surat Tugas');
      console.log(textStatus);
    }
  });
  return false;
}

function trigerFileInput(inputName, idx) {
  var fileName = $('[name=\''+inputName+'\']').prop('files')[0].name;
  $('.custom-file-input-surat-tugas-' + idx).addClass("selected").html(fileName);
  return false;
}