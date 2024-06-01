$(document).ready(function() {
  lazyLoadImg('lazy-load-img');

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
      $('.total-nilai-fix').attr('data-total-nilai-value', Math.ceil(totalNilaiUjian)).text(calculateNilai(totalNilaiUjian));

    }
  });

  if (querystringParam('typeAct') !== undefined) {
    /** Load Edit Data Input Nilai */
    var mahasiswaId = querystringParam('mahasiswaId');
    var inputNilaiId = querystringParam('inputNilaiId');
    getDataInputNilai(inputNilaiId, mahasiswaId);

    $('.btn-back').removeAttr('onclick').attr('onclick', 'BackToHasilNilai()');
    $('.btn-save-nilai').text('Update Nilai');
    return false;
  }

});

function getDataInputNilai(inputJadwalNilaiId, mahasiswaId) {
  var formData = new FormData($('<form>')[0]);

  formData.append('input_nilai_id', inputJadwalNilaiId);
  formData.append('mahasiswa_id', mahasiswaId);

  var url = baseURL + `/inputNilai/getDataNilai?prefixData=${$('[name=prefixData]').val()}`;

  $.ajax({
    url: url,
    type: "POST",
    data: formData,
    dataType: "JSON",
    contentType: false,
    cache: false,
    processData: false,
    enctype: 'multipart/form-data',
    beforeSend: function(item) {},
    success: function(data) {
      switch(data.code) {
        case 201:
          var valueInput = data.response.instrument_data;
          console.log(valueInput);

          for (let i = 0; i < valueInput.length; i++) {
            $('[name=\''+ valueInput[i].element_name +'\']').val(valueInput[i].element_value).trigger('change');
            $(".only-number").keyup();
          }

          $('[name=catatan]').val(data.response.catatan);
          $('[name=kesimpulan][value="'+ data.response.kesimpulan +'"]').prop('checked',true);
          $('[name=input_nilai_id]').val(data.response.input_nilai_id);
        break;
        default:
         throw data.response;
        break;
      }

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });
  return false;
}

function querystringParam(key) {
   var re=new RegExp('(?:\\?|&)'+key+'=(.*?)(?=&|$)','gi');
   var r=[], m;
   while ((m=re.exec(document.location.search)) != null) r[r.length]=m[1];
   return r[0];
}

function BackToHasilNilai() {
  var url = baseURL +'/hasilNilai';
  return window.location.href = url;
}


function calculateNilai(value) {
  var __val = Math.ceil(value);

  var result = '';
  if (__val >= 100) {
    result = 'A';
  } else if (__val >= 86 && __val <= 100) {
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
  var url = baseURL +'/inputNilai';
  return window.location.href = url;
}

function openfile(url) {
  return window.open(url, "popupWindow", "width=700,height=700,scrollbars=yes");
}

function simpanNilaiSUP(event) {
  var formData = new FormData($('#formIsiNilai')[0]);

  var valid = true;
  var allInstrumenInput = $('.sum-input');
  var catatan = $('[name=catatan]');
  var kesimpulan = $('[name=kesimpulan]');

  catatan.removeClass('is-invalid');

  for (var i = 0; i < allInstrumenInput.length; i++) {
    $(allInstrumenInput[i]).removeClass('is-invalid');
    valid = true;

    if ($(allInstrumenInput[i]).val() == '') {
      $(allInstrumenInput[i]).addClass('is-invalid');
      valid = false;
    }
    
  }

  if (catatan.val() == '') {
    catatan.addClass('is-invalid');
    valid = false;
  }

  if (!valid) {
    return false;
  }

  formData.append('formulir_sup_id', $('[name=formulir_sup_id]').val());
  formData.append('input_nilai_id', $('[name=input_nilai_id]').val());
  formData.append('input_jadwal_type', 'sup');
  formData.append('mahasiswa_id', $('[name=mahasiswaId]').val());
  formData.append('dosen_id', $('[name=dosenId]').val());
  formData.append('catatan', catatan.val());
  formData.append('kesimpulan', $('[name=kesimpulan]:checked').val());

  var arrInstrument = [];
  for (var i = 0; i < allInstrumenInput.length; i++) {
    arrInstrument.push({
      element_name: $(allInstrumenInput[i]).attr('name'),
      element_value: $(allInstrumenInput[i]).val(),
    });
  }
  arrInstrument.push({
    total_all_instrument_iput: $('.sum-value-nilaiXbobot').text(),
    nilai_akhir_nu: $('.total-nilai-fix').text(),
    total_nilai_value: $('.total-nilai-fix').data('total-nilai-value'),
  });
  formData.append('instrument_data', JSON.stringify(arrInstrument));

  var url = '';
  if (querystringParam('typeAct') !== undefined) {
    /** Update Nilai */
    url = baseURL + `/inputNilai/upudateNilai?prefixData=${$('[name=prefixData]').val()}`;
  } else {
    /** Save Nilai */
    url = baseURL + `/inputNilai/addNilai?prefixData=${$('[name=prefixData]').val()}`;
  }
  

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

            if (querystringParam('typeAct') !== undefined) {
              BackToHasilNilai();
            } else {
              Back();
            }
            
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

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });
  return false;
}

function simpanNilaiSKripsi() {
  var formData = new FormData($('#formIsiNilai')[0]);

  var valid = true;
  var allInstrumenInput = $('.sum-input');
  var catatan = $('[name=catatan]');
  var kesimpulan = $('[name=kesimpulan]');

  catatan.removeClass('is-invalid');

  for (var i = 0; i < allInstrumenInput.length; i++) {
    $(allInstrumenInput[i]).removeClass('is-invalid');
    valid = true;

    if ($(allInstrumenInput[i]).val() == '') {
      $(allInstrumenInput[i]).addClass('is-invalid');
      valid = false;
    }
    
  }

  if (catatan.val() == '') {
    catatan.addClass('is-invalid');
    valid = false;
  }

  if (!valid) {
    return false;
  }

  formData.append('formulir_skripsi_id', $('[name=formulir_skripsi_id]').val());
  formData.append('input_nilai_id', $('[name=input_nilai_id]').val());
  formData.append('input_jadwal_type', 'skripsi');
  formData.append('mahasiswa_id', $('[name=mahasiswaId]').val());
  formData.append('dosen_id', $('[name=dosenId]').val());
  formData.append('catatan', catatan.val());
  formData.append('kesimpulan', $('[name=kesimpulan]:checked').val());

  var arrInstrument = [];
  for (var i = 0; i < allInstrumenInput.length; i++) {
    arrInstrument.push({
      element_name: $(allInstrumenInput[i]).attr('name'),
      element_value: $(allInstrumenInput[i]).val(),
    });
  }
  arrInstrument.push({
    total_all_instrument_iput: $('.sum-value-nilaiXbobot').text(),
    nilai_akhir_nu: $('.total-nilai-fix').text(),
    total_nilai_value: $('.total-nilai-fix').data('total-nilai-value'),
  });
  formData.append('instrument_data', JSON.stringify(arrInstrument));

  var url = '';
  if (querystringParam('typeAct') !== undefined) {
    /** Update Nilai */
    url = baseURL + `/inputNilai/upudateNilai?prefixData=${$('[name=prefixData]').val()}`;
  } else {
    /** Save Nilai */
    url = baseURL + `/inputNilai/addNilai?prefixData=${$('[name=prefixData]').val()}`;
  }
  
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
            if (querystringParam('typeAct') !== undefined) {
              BackToHasilNilai();
            } else {
              Back();
            }
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

    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });
  return false;
}