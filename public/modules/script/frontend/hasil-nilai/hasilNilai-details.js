$(document).ready(function() {
  lazyLoadImg('lazy-load-img');
  getDataPenugasanDosenPenguji();

  /** Onclick TAB Panel */
  $('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
  });
  /** [END] - Onclick TAB Panel */

  $('.only-number').keyup(function(e) {
    if (/\D/g.test(this.value)) {
      this.value = this.value.replace(/[^0-9]/g, '');
      return false;
    } else {
      var Allinput = $('input.sum-input');

      var sumNilai = 0;
      Allinput.each(function() {
        sumNilai += Number($(this).val());
      });

      /** Calculate Nilai X Bobot */
      $(`[name=nilaiXbobot-${$(this).attr('name')}]`).attr('data-input-total', (this.value * $(this).data('bobot'))).val((this.value * $(this).data('bobot')));
      /** [END] - Calculate Nilai X Bobot */

      /** Summary Nilai X Bobot */
      var sumTotalNilaiXBobor = 0;
      $('.disp-final-val').each(function() {
        sumTotalNilaiXBobor += Number($(this).val());
      });
      $('.sum-value-nilaiXbobot').text(Math.ceil(sumTotalNilaiXBobor));
      /** [END] - Summary Nilai X Bobot */

      var totalNilaiUjian = (sumTotalNilaiXBobor / 10);
      $('.total-nilai-fix').text(calculateNilai(totalNilaiUjian));

    }
  });
});


function calculateNilai(value) {
  var __val = Math.ceil(value);

  var result = '';
  if (__val >= 100) {
    result = 'A';
  }else if (__val >= 86 && __val <= 100) {
    result = 'A';
  } else if (__val >= 81 && __val <= 85) {
    result = 'A-';
  } else if (__val >= 76 && __val <= 80) {
    result = 'B+';
  } else if (__val >= 71 && __val <= 75) {
    result = 'B';
  } else if (__val >= 66 && __val <= 70) {
    result = 'B-';
  } else if (__val >= 61 && __val <= 65) {
    result = 'C+';
  } else if (__val >= 56 && __val <= 61) {
    result = 'C';
  } else if (__val >= 51 && __val <= 56) {
    result = 'C-';
  } else if (__val >= 46 && __val <= 51) {
    result = 'D+';
  } else if (__val >= 41 && __val <= 46) {
    result = 'D';
  } else if (__val >= 0 && __val <= 41) {
    result = 'E';
  }

  return result;
}


function Back() {
  var url = baseURL +'/hasilNilai';
  return window.location.href = url;
}

function openfile(url) {
  return window.open(url, "popupWindow", "width=700,height=700,scrollbars=yes");
}

function printDokument(event) {
  window.print();
}

function getDataPenugasanDosenPenguji() {
  var formulirId = '';
  if ($('[name=prefixData]').val() == 'sup') {
    formulirId = $('[name=formulir_sup_id]').val(); 
  }

  if ($('[name=prefixData]').val() == 'skripsi') {
    formulirId = $('[name=formulir_skripsi_id]').val(); 
  }

  var url = baseURL + `/hasilNilai/getDataPenugasanDosenPenguji?type=${$('[name=prefixData]').val()}&formulirId=${formulirId}`;

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

          elList += '<li class="list-li-dosen" onclick="viewsDataNilaiPerDosen(\''+data[i].dosen_id+'\');">' +
            '<div class="parent-section-list-dosen">' +
              '<div class="section-list-item">' +
                '<div>' +
                  '<img class="lazy-load-img avatar-disp" src="'+ loaderImg +'" data-src="'+ uriThumnails +'" width="60" height="60" alt="images" />' +
                '</div>' +
                '<div class="section-list-item-name">'+ data[i].nama_dosen.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                  return letter.toUpperCase();
                }) +'</div>' +
              '</div>';
            elList += '<div class="section-list-item-jabatan">'+ data[i].type_penugasan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
              }) +'</div>';
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

function viewsDataNilaiPerDosen(dosenId) {
  var url = baseURL + `/hasilNilai/views?dosenId=${dosenId}&mahasiswaId=${$('[name=mahasiswaId]').val()}&prefixData=${$('[name=prefixData]').val()}`;
  return window.location.href = url;
}

function editInputNilaiSup(event) {
  var url = baseURL + `/inputNilai/form?q=${$('[name=formulir_sup_id]').val()}&type=sup&inputNilaiId=${$('[name=jadwalInputNilaiId]').val()}&mahasiswaId=${$('[name=mahasiswaId]').val()}&typeAct=editNilai`;
  return window.location.href = url;
}

function editInputNilaiSkripsi(event) {
  var url = baseURL + `/inputNilai/form?q=${$('[name=formulir_skripsi_id]').val()}&type=skripsi&inputNilaiId=${$('[name=jadwalInputNilaiId]').val()}&mahasiswaId=${$('[name=mahasiswaId]').val()}&typeAct=editNilai`;
  return window.location.href = url;
}