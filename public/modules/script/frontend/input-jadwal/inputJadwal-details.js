$(document).ready(function() {
  lazyLoadImg('lazy-load-img');
  getDataPenugasanDosenPenguji();

  $(".custom-file-input-surat-tugas").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label-surat-tugas").addClass("selected").html(fileName);
  });

  var currentDate = new Date();
  $("[name=tanggal]").datepicker({ 
    autoclose: true,
    dateFormat: 'dd-mm-yyyy',
    format: 'dd-mm-yyyy',
    daysOfWeekDisabled: [],
    changeMonth: true,
    changeYear: true,
    onSelect: function(selectedDate) {
      console.log(selectedDate);
    }
  }).datepicker('setDate', currentDate);

  // $('[name=waktuMulai]').mdtimepicker({
  //   timeFormat:'hh:mm',
  //   format:'h:mm',
  //   theme:'blue',
  //   readOnly: false,  
  //   hourPadding: true,
  //   clearBtn:true
  // }).on('timechanged',function(e) {
  //   console.log(e.value);
  //   console.log(e.time);
  // });

  $('[name=waktuMulai]').timepicker({
    timeFormat: 'HH:mm',
    interval: 60,
    minTime: '00:00',
    maxTime: '23:00',
    defaultTime: '',
    startTime: '00:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

  $('[name=waktuAkhir]').timepicker({
    timeFormat: 'HH:mm',
    interval: 60,
    minTime: '00:00',
    maxTime: '23:00',
    defaultTime: '',
    startTime: '00:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });

});


function Back() {
  var url = baseURL +'/inputJadwal';
  return window.location.href = url;
}

function openfile(url) {
  return window.open(url, "popupWindow", "width=700,height=700,scrollbars=yes");
}

function getDataPenugasanDosenPenguji() {

  var formulirId = '';
  if ($('[name=prefixData]').val() == 'uji_kelayakan') {
    formulirId = $('[name=ujiKelayakanId]').val(); 
  }

  if ($('[name=prefixData]').val() == 'sup') {
    formulirId = $('[name=supId]').val(); 
  }

  if ($('[name=prefixData]').val() == 'skripsi') {
    formulirId = $('[name=skripsiId]').val(); 
  }

  var url = baseURL + `/inputJadwal/getDataPenugasanDosenPenguji?type=${$('[name=prefixData]').val()}&formulirId=${formulirId}`;

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

            elList += '<div class="section-list-item-jabatan custom-file-input-surat-tugas-'+i+'" data-dosenid'+i+'="'+data[i].dosen_id+'">'+ data[i].type_penugasan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
              }) +'</div>';

              if (data[i].rules == 4) {
                elList += '<div class="section-list-item-btn-delete">' +
                '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="DeletePenugasanDosen(\''+ data[i].penugasan_id +'\');" title="Delete data">' +
                  '<i class="fa fa-trash" aria-hidden="true"></i>' +
                '</button>' +
              '</div>';
              }

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

function kirimJadwalSidang() {
  var lengthData = $('.list-li-dosen').length;
  var dataDospem = $('.list-li-dospem');

  var elForm = document.createElement("form");
  elForm.id  = 'formKirimJadwalSidang';

  var valid = true;

  var tempat = $('[name=tempat]');
  var tanggal = $('[name=tanggal]');
  var waktuMulai = $('[name=waktuMulai]');
  var waktuAkhir = $('[name=waktuAkhir]');
  var semester = $('[name=semester]');

  $(tempat).removeClass('is-invalid');
  $(tanggal).removeClass('is-invalid');
  $(waktuMulai).removeClass('is-invalid');
  $(waktuAkhir).removeClass('is-invalid');
  $(semester).removeClass('is-invalid');

  if (tempat.val() == '') {
    $(tempat).addClass('is-invalid');
    valid = false;
  }

  if (tanggal.val() == '') {
    $(tanggal).addClass('is-invalid');
    valid = false;
  }

  if (waktuMulai.val() == '') {
    $(waktuMulai).addClass('is-invalid');
    valid = false;
  }

  if (waktuAkhir.val() == '') {
    $(waktuAkhir).addClass('is-invalid');
    valid = false;
  }

  if (semester.val() == '') {
    $(semester).addClass('is-invalid');
    valid = false;
  }

  var formData = new FormData($(elForm)[0]);

  if ($('[name=prefixData]').val() == 'uji_kelayakan') {
    formData.append('ujiKelayakanId', $('[name=ujiKelayakanId]').val());
  }

  if ($('[name=prefixData]').val() == 'sup') {
    formData.append('supId', $('[name=supId]').val());
  }

  if ($('[name=prefixData]').val() == 'skripsi') {
    formData.append('skripsiId', $('[name=skripsiId]').val());
  }
  
  formData.append('judul', $('[name=judul]').val());
  formData.append('tempat', $('[name=tempat]').val());
  formData.append('tanggal', $('[name=tanggal]').val());
  formData.append('waktuMulai', $('[name=waktuMulai]').val());
  formData.append('waktuAkhir', $('[name=waktuAkhir]').val());
  formData.append('semester', $('[name=semester]').val());
  formData.append('keterangan', $('[name=keterangan]').val());

  for (var i = 0; i < lengthData; i++) {
    var dosenID = $('.custom-file-input-surat-tugas-' + i).data('dosenid' + i);
    formData.append('dosenId[]', dosenID);
  }

  for (var i = 0; i < dataDospem.length; i++) {
    var dosenID = $(dataDospem[i]).data('dospemid');
    formData.append('dosenId[]', dosenID);
  }

  if (!valid) {
    return false;
  }

  var url = baseURL + `/inputJadwal/addJadwal?prefixData=${$('[name=prefixData]').val()}`;

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

            var url = baseURL +'/jadwalSidang';
            return window.location.href = url;
          });
        break;
      case 302:
          swal({
            title: 'Perhatian',
            content: {
              element: 'div',
              attributes: {
                innerHTML: `${data.response}`,
              },
            },
            html: true,
            icon: "info",
            closeOnClickOutside: false,
            ok: {
              text: "OK",
              value: "action-ok",
            },
          }).then((value) => {});
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

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });
  return false;
  
}