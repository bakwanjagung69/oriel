$(document).ready(function() {
  lazyLoadImg('lazy-load-img');
  getDataPenugasanDosenPembimbing();
  tableAddDataDosenPembimbing([]);
  getDataPenugasanDosenList();

  $(".custom-file-input-surat-tugas").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label-surat-tugas").addClass("selected").html(fileName);
  });
});


function Back() {
  var url = baseURL +'/inputNamaDosenPembimbing';
  return window.location.href = url;
}

function openfile(url) {
  return window.open(url, "popupWindow", "width=700,height=700,scrollbars=yes");
}

function getDataPenugasanDosenPembimbing() {

  var url = baseURL + `/inputNamaDosenPembimbing/getDataPenugasanDosenPembimbing?formulirId=${$('[name=ujiKelayakanJudulId]').val()}`;

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

              if ($('[name=prefixData]').val() == 'uji_kelayakan' && data[i].rules == 2) {
                elList += '<div class="section-list-item-input-files">' +
                    '<div class="custom-file">' +
                      '<input type="file" name="surat_tugas_file_to_list_dosen-'+i+'" onchange="trigerFileInput(\'surat_tugas_file_to_list_dosen-'+i+'\', '+i+');" class="custom-file-input-surat-tugas-'+i+'" id="customFileSuratTugas-'+i+'" data-dosenid'+i+'="'+data[i].dosen_id+'">' +
                      '<label class="custom-file-label custom-file-input-surat-tugas-'+i+'" for="customFileSuratTugas-'+i+'">Choose file</label>' +
                    '</div>' +
                '</div>';                
              }

            elList += '<div class="section-list-item-jabatan">'+ data[i].type_penugasan.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
              }) +'</div>';

              if (data[i].rules == 4) {
                if ($('[name=status]').val() !== '7') {
                elList += '<div class="section-list-item-btn-delete">' +
                  '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="DeletePenugasanDosen(\''+ data[i].penugasan_id +'\');" title="Delete data">' +
                    '<i class="fa fa-trash" aria-hidden="true"></i>' +
                  '</button>' +
                '</div>';
                }
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

function trigerFileInput(inputName, idx) {
  var fileName = $('[name=\''+inputName+'\']').prop('files')[0].name;
  $('.custom-file-input-surat-tugas-' + idx).addClass("selected").html(fileName);
  return false;
}

function addPenugasanDosenPenguji() {
  $('#modalPenugasanDosen').modal('toggle');
  $('#modalPenugasanDosen').modal('show');
}

function getDataPenugasanDosenList() {
  var url = baseURL +'/inputNamaDosenPembimbing/dosenList';

  $.ajax({
      url : url,    
      type: "GET",
      dataType: "JSON",
      beforeSend: function(item) {

      },
      success: function(data) {
        var setArr = [];
        for (var i = 0; i < data.length; i++) {
          setArr.push({
            id: data[i].id,
            text: data[i].full_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
            }),
          });
        }

        $('[name=list-dosen]').select2({
          dropdownParent: $("#modalPenugasanDosen"),
          width: '100%',
          minimumInputLength: 0,
          dropdownAutoWidth : true,
          allowClear: true,
          placeholder: '--Pilih--',
          delay: 250,
          data: setArr
        }).on('change', function (e) {});

      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(textStatus);
      }
    });
}

function addDataToTablePenugasanDosen(event) {
  // $('[name="list-dosen"]').val('').trigger('change');

  var optionListDosen = $('[name="list-dosen"]').select2('data');
  var dosenID = optionListDosen[0].id;
  var dosenName = optionListDosen[0].text;
  var typePenugasan = $('[name="type-penugasan"]');

  var valid = true;
  $($($($('[name=list-dosen]').next()).find('span')[0]).find('span')[0]).css('border', '1px solid #aaa');
  typePenugasan.removeClass('is-invalid');

  if (dosenID == '') {
    $($($($('[name=list-dosen]').next()).find('span')[0]).find('span')[0]).css('border', '1px solid #f00');
    valid = false
  }

  if (typePenugasan.val() == '') {
    $(typePenugasan).addClass('is-invalid');
    valid = false
  }

  if (!valid) {
    return false;
  }

  var getArryDosenListTable = $('#__tableAddDataDosenPembimbingListItems').DataTable().data().toArray();
  var jsonDosenList = [];

  if ((getArryDosenListTable.length + 1) > 2) {
   swal({
      title: "Oops!",
      content: {
          element: 'div',
          attributes: {
            innerHTML: `Dosen yang dipilih hanya diperbolehkan 2`,
          },
        },
      html: true,
      icon: "warning",
      closeOnClickOutside: false,
    }).then((value) => {
      $('[name="list-dosen"]').val('').trigger('change');
      typePenugasan.val('').trigger('change');
    });
    return false;
  } 

  if (getArryDosenListTable.length == 0) {
    tableAddDataDosenPembimbing([{
      uji_kelayakan_id: $('[name=ujiKelayakanJudulId]').val(),
      kaprodi_id: $('[name=kaprodiId]').val(),
      dosen_id: dosenID,
      nama_dosen: dosenName,
      type_penugasan: typePenugasan.val()
    }]);

  } else {
    var checkDuplicateId = getArryDosenListTable.filter(e => e.dosen_id === dosenID).length;
    if (checkDuplicateId == 1) {
      swal({
        title: "Oops!",
        content: {
            element: 'div',
            attributes: {
              innerHTML: `Nama Dosen <b>${dosenName.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
            })}</b> sudah di pilih!`,
            },
          },
        html: true,
        icon: "warning",
        closeOnClickOutside: false,
      }).then((value) => {
        $('[name="list-dosen"]').val('').trigger('change');
        typePenugasan.val('').trigger('change');
      });
      return false;
    }

    var checkTypePenugasan = getArryDosenListTable.filter(e => e.type_penugasan === typePenugasan.val()).length;
    if (checkTypePenugasan == 1) {
      swal({
        title: "Oops!",
        content: {
            element: 'div',
            attributes: {
              innerHTML: `Type Penugasan Dosen <b>${typePenugasan.val().toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
            })}</b> sudah di pilih!`,
            },
          },
        html: true,
        icon: "warning",
        closeOnClickOutside: false,
      }).then((value) => {
        $('[name="list-dosen"]').val('').trigger('change');
        typePenugasan.val('').trigger('change');
      });
      return false;
    }

    jsonDosenList.push({
        uji_kelayakan_id: $('[name=ujiKelayakanJudulId]').val(),
        kaprodi_id: $('[name=kaprodiId]').val(),
        dosen_id: dosenID,
        nama_dosen: dosenName,
        type_penugasan: typePenugasan.val()
      });

      getArryDosenListTable.forEach(function(element, index) {
        jsonDosenList.push({
          uji_kelayakan_id: $('[name=ujiKelayakanJudulId]').val(),
          kaprodi_id: $('[name=kaprodiId]').val(),
          dosen_id: element.dosen_id,
          nama_dosen: element.nama_dosen,
          type_penugasan: element.type_penugasan
        });
      });

    tableAddDataDosenPembimbing(jsonDosenList);
  }

  $('[name="list-dosen"]').val('').trigger('change');
  typePenugasan.val('').trigger('change');
  return false;
}

function tableAddDataDosenPembimbing(dataSet) {
  if ( $.fn.DataTable.isDataTable('#__tableAddDataDosenPembimbingListItems') ) {
    $('#__tableAddDataDosenPembimbingListItems').DataTable().destroy();
  };

  $('#__tableAddDataDosenPembimbingListItems').DataTable({
      data: dataSet,
      columns: [       
        { 
          "data": "nama_dosen",
          "orderable": true,
          "className": "dt-left",
          render: function (data, type, row, meta) {
            var str = data;
            str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
            });
            return str;
          }
        },
        {
          "data": "type_penugasan",
          "orderable": true,
          "className": "dt-left",
          render: function (data, type, row, meta) {
            var str = data;
            str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
            });
            return str;
          }
        },
        { 
          "data": "dosen_id",
          "orderable": false,
          "className": "dt-center",
          render: function (data, type, row, meta) {
            var html = '<div class="btn-group">' +
              '<button type="button" class="btn btn-danger btn-sm" onclick="DeleteObjectArrDosenPenguji(\''+row.nama_dosen+'\');">' +
                '<i class="fa fa-trash" aria-hidden="true"></i>' +
              '</button>' +
            '</div>';
            return html;
          }
        },
      ],
      "lengthMenu": [[5, 15, 50, -1], [5, 15, 50, "All"]]
  });
  return false;
}


function DeleteObjectArrDosenPenguji(value) {
  var __tables = $('#__tableAddDataDosenPembimbingListItems').DataTable();
  $.confirm({
       title: 'ATTENTION!',
       content: 'Are you sure you want to delete this image <b>'+value+'?</b>',
       type: 'red',
       typeAnimated: true,
       autoClose: 'Cancel|8000',
       buttons: {
        btnOK: {
          text: 'OK',
          btnClass: 'btn-red',
          action: function(event) {
            __tables.rows( function(idx, data, node) {
              return data.nama_dosen == value;
              }).remove().draw();

            var _listData = __tables.rows().data();
            if (_listData.length == 0) {
              $('#btn-save').prop("disabled", true);
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

function saveDataPenugasanDosenPembimbing() {
  var formData = new FormData($('#formPenugasanDosenPembimbing')[0]);
  var getArryDosenListTable = $('#__tableAddDataDosenPembimbingListItems').DataTable().data().toArray();

  if ((getArryDosenListTable.length) < 2 || (getArryDosenListTable.length) == 1) {
    swal({
      title: "Oops!",
      content: {
          element: 'div',
          attributes: {
            innerHTML: `Dosen yang dipilih tidak boleh kurang dari 2`,
          },
        },
      html: true,
      icon: "warning",
      closeOnClickOutside: false,
    }).then((value) => {
      $('[name="list-dosen"]').val('').trigger('change');
      typePenugasan.val('').trigger('change');
    });
    return false;
  }

  formData.append('data', JSON.stringify(getArryDosenListTable));
  formData.append('uji_kelayakan_judul_id', $('[name=ujiKelayakanJudulId]').val());
  formData.append('mahasiswa_id', $('[name=mhsId]').val());

  var url = baseURL +'/inputNamaDosenPembimbing/addPenugasanDosenPembimbing';

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
            $('#modalPenugasanDosen').modal('toggle');
            $('#modalPenugasanDosen').modal('hide');
            getDataPenugasanDosenPembimbing();
            tableAddDataDosenPembimbing([]);
            Back();
          });
        break;
        case 304:
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
          }).then((value) => {
            getDataPenugasanDosenPembimbing();
            tableAddDataDosenPembimbing([]);
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


function DeletePenugasanDosen(id) {
    var url = baseURL + `/inputNamaDosenPembimbing/DeletePenugasanDosenPembimbing?q=${id}`;

    $.confirm({
      title: 'Are you sure delete this data?',
      type: 'red',
      content: 'Will cancel automatically in 6 seconds if you don\'t respond!',
      autoClose: 'Cancel|8000',
      buttons: {
        Deleted: {
          text: 'OK',
          btnClass: 'btn-red',
          action: function () {
            $.ajax({
              url : url,    
              type: "DELETE",
              dataType: "JSON",
              success: function(data) {
                getDataPenugasanDosenPembimbing();
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
              }
          });          
          $.alert('<div class="popupAlert">Data deleted successfully!</div>');
        }
      },
      Cancel: {
      text: 'Cancel',
        action: function () {
          return;
          // $.alert('<div class="popupAlert">Delete canceled</div>');
        }
      }
    }
  });
  return false;
}
