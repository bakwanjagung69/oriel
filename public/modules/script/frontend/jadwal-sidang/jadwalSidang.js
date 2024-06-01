var tableUjiKelayakan;
var tableSUP;
var tableSkripsi;
$( document ).ready(function() {

  /** Notfy for if table can expand row */
  // Pnotify(
  //   'Info!', 
  //   'Click the table row to expand the content.', 
  //   3000, 
  //   '#337ab7'
  // );
  /** [END] - Notfy for if table can expand row */

  /** DataTables */
  var loaders = "<div style='background-color: #fff;'>" +
                  "<img class='loader-icon' src='"+ (baseURL + '/files/loaderImg?loader=loader-image-data-table') +"' style='width: 50%;'>" +
                  "<div><h4>Loading...</h4></div>" +
                "</div>";

  /** Handler Error Ajax Call DataTables */
  $.fn.dataTable.ext.errMode = function (settings, helpPage, message) { 
    // console.log(settings);
    console.log({
      url: settings.ajax.url,
      type: settings.ajax.type,
      columns: settings.oInit.columns,
      errors: message
    });
  };       
  /** [END] - Handler Error Ajax Call DataTables */

  /** DatetTable SUP */
  tableSUP = $('#table-sup').DataTable({ 
    // responsive: {
    //   details: {
    //     display: $.fn.dataTable.Responsive.display.childRow,
    //     type: 'column',
    //     target: 'td.details-control'
    //   }
    // },
    // oLanguage: {
    //   sProcessing: loaders
    // },
    dom: 'Bfrtip',
    buttons: [
      {
        text: 'Refresh <i class="fa fa-refresh" aria-hidden="true"></i>',
        action: function ( e, dt, node, config ) {
          reloadTable(tableSUP);
        }
      },
      {
        extend: 'pageLength',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
      },
      {
        extend: 'colvis',
        columnText: function ( dt, idx, title ) {
            return title;
        }
      },
      {
          extend: 'print',
          messageTop: '',
          text: 'Print <i class="fa fa-print"></i>'
      },
      {
          extend:    'copyHtml5',
          text:      '<i class="fa fa-files-o"></i>',
          titleAttr: 'Copy'
      },
      {
          extend:    'excelHtml5',
          text:      'Export Xls <i class="fa fa-file-excel-o"></i>',
          titleAttr: 'Export All data to Excel',
          action: function ( e, dt, node, config ) {
            var url = baseURL +'/jadwalSidang/exportExlsSUP';
            return window.location.href = url;
          }
      },
      // {
      //     extend:    'csvHtml5',
      //     text:      '<i class="fa fa-file-text-o"></i>',
      //     titleAttr: 'CSV'
      // },
      // {
      //     extend:    'pdfHtml5',
      //     text:      '<i class="fa fa-file-pdf-o"></i>',
      //     titleAttr: 'PDF'
      // },
  ],
    "processing": true,
    "serverSide": true,
    "order": [], 
    "ajax": {
      "url": baseURL + "/jadwalSidang/getdataSUP",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-sup]').val();
      },         
    },
    "initComplete": function(settings, json) {
      lazyLoadImg('lazy-load-img');
      // console.log('initComplete');
    },
    //Set column definition initialisation properties.
    "columns": [
      {
          "data": "id",
          "orderable": true,
          "width" : "5",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1 + '.';
          }
      },
      { 
        "data": "nim",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "nama",
        "className": "details-control cursor-pointer"
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return '<div>'+
                '<div>'+ row.disp_hari_idn +'</div>' +
                '<div>'+ row.tanggal +'</div>' +
                '<div>'+ row.waktu_mulai + '-' + row.waktu_akhir +'</div>' +
                '<div><b>'+ row.tempat +'</b></div>' +
              '</div>';
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var ketua = row.dospemSUPData.find((item) => { return item['type_penugasan'] === 'ketua' });
            ketua = (ketua !== undefined) ? ketua.dosen_name.substr(0,1).toUpperCase()+ketua.dosen_name.substr(1) : '';
            return ketua;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var anggota = row.dospemSUPData.find((item) => { return item['type_penugasan'] === 'anggota' });
            anggota = (anggota !== undefined) ? anggota.dosen_name.substr(0,1).toUpperCase()+anggota.dosen_name.substr(1) : '';
            return anggota;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var pembimbing1 = row.dospemUjiKelatakanData.find((item) => { return item['type_penugasan'] === 'pembimbing 1' });
            pembimbing1 = (pembimbing1 !== undefined) ? pembimbing1.dosen_name.substr(0,1).toUpperCase()+pembimbing1.dosen_name.substr(1) : '';
            return pembimbing1;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var pembimbing2 = row.dospemUjiKelatakanData.find((item) => { return item['type_penugasan'] === 'pembimbing 2' });
            pembimbing2 = (pembimbing2 !== undefined) ? pembimbing2.dosen_name.substr(0,1).toUpperCase()+pembimbing2.dosen_name.substr(1) : '';
            return pembimbing2; 
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var pengujiLuar = row.dospemSUPData.find((item) => { return item['type_penugasan'] === 'penguji luar' });
            pengujiLuar = (pengujiLuar !== undefined) ? pengujiLuar.dosen_name.substr(0,1).toUpperCase()+pengujiLuar.dosen_name.substr(1) : '';
            return pengujiLuar;
          }
      },
      { 
        "data": "judul",
        "className": "details-control cursor-pointer dt-center"
      }, 
      {
          "data": "keterangan",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            return data;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var ele = '';
            var headColumn = tableSUP.columns(11).header();

            switch(row.status) {
              case '0':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '';
                  }
                  
                break;
                case '1':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '';
                  }
                  
                break;
                case '2':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '';
                  }
                break;
                case '3':
                  if (row.userRules == '1') {
                    /** Administrator */
                    ele = '';
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 10px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }

                  if (row.userRules == '4') {
                    /** Kaprodi */
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    var url = baseURL + `/jadwalSidang/details?q=${row.formulir_sup_id}&type=sup`;
                    ele = '<div>'+
                      '<div>'+
                        '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>' +
                      '</div>' +
                      '<br>' +
                      '<a href="'+ url + '" class="btn btn-outline-secondary btn-sm" target="_parent">Edit Jadwal</a>' +
                    '</div>';
                  }

                  if (row.userRules == '3') {
                    /** Dosen */
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }

                  if (row.userRules == '5') {
                    /** Mahasiswa */
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }
                break;
                case '4':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                  }

                  if (row.userRules == '3') {
                    /** Dosen */
                    ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                  }

                  if (row.userRules == '5') {
                    /** Mahasiswa */
                    ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                  }
                break;
              }

           return ele;
          }
      },
      // uncomment if table use expand row
      // {
      //   "data": "id",
      //   "orderable": false,
      //   "className": "dt-center",
      //   "width": "100%",
      //   render: function (data, type, row, meta) {
      //     return '<div class="box box-info">' +
      //       '<div class="box-header"></div>' +
      //       '<div class="box-body">'+ row.description +'</div>' +
      //     '</div>';
      //   }
      // }       
    ]
  });

  // $('#table-sup tbody').on('click', 'tr', function () {
  //   var formulir_sup_id = tableSUP.row(this).data().formulir_sup_id;

  //   var tempat = tableSUP.row(this).data().tempat;
  //   var tanggal_dan_waktu = tableSUP.row(this).data().tanggal_dan_waktu;

  //   var url = baseURL + `/jadwalSidang/details?q=${formulir_sup_id}&type=sup&tempat=${tempat}&tanggalWaktu=${tanggal_dan_waktu}`;
  //   return window.location.href = url;
  // });
  /** [END] - DatetTable SUP */

  /** DatetTable Skripsi */
  tableSkripsi = $('#table-skripsi').DataTable({ 
    // responsive: {
    //   details: {
    //     display: $.fn.dataTable.Responsive.display.childRow,
    //     type: 'column',
    //     target: 'td.details-control'
    //   }
    // },
    // oLanguage: {
    //   sProcessing: loaders
    // },
    dom: 'Bfrtip',
    buttons: [
      {
        text: 'Refresh <i class="fa fa-refresh" aria-hidden="true"></i>',
        action: function ( e, dt, node, config ) {
          reloadTable(tableSkripsi);
        }
      },
      {
        extend: 'pageLength',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
      },
      {
        extend: 'colvis',
        columnText: function ( dt, idx, title ) {
            return title;
        }
      },
      {
          extend: 'print',
          messageTop: 'Data Users',
          text: 'Print <i class="fa fa-print" aria-hidden="true"></i>'
      },
      {
          extend:    'copyHtml5',
          text:      '<i class="fa fa-files-o"></i>',
          titleAttr: 'Copy'
      },
      {
          extend:    'excelHtml5',
          text:      'Export Xls <i class="fa fa-file-excel-o"></i>',
          titleAttr: 'Export All data to Excel',
          action: function ( e, dt, node, config ) {
            var url = baseURL +'/jadwalSidang/exportExlsSkripsi';
            return window.location.href = url;
          }
      },
      // {
      //     extend:    'csvHtml5',
      //     text:      '<i class="fa fa-file-text-o"></i>',
      //     titleAttr: 'CSV'
      // },
      // {
      //     extend:    'pdfHtml5',
      //     text:      '<i class="fa fa-file-pdf-o"></i>',
      //     titleAttr: 'PDF'
      // },
  ],
    "processing": true,
    "serverSide": true,
    "order": [], 
    "ajax": {
      "url": baseURL + "/jadwalSidang/getdataSkripsi",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-skripsi]').val();
      },         
    },
    "initComplete": function(settings, json) {
      lazyLoadImg('lazy-load-img');
      // console.log('initComplete');
    },
    //Set column definition initialisation properties.
    "columns": [
      {
          "data": "id",
          "orderable": true,
          "width" : "5",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1 + '.';
          }
      },
      { 
        "data": "nim",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "nama",
        "className": "details-control cursor-pointer"
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return '<div>'+
                '<div>'+ row.disp_hari_idn +'</div>' +
                '<div>'+ row.tanggal +'</div>' +
                '<div>'+ row.waktu_mulai + '-' + row.waktu_akhir +'</div>' +
                '<div><b>'+ row.tempat +'</b></div>' +
              '</div>';
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var ketua = row.dospemSkripsiData.find((item) => { return item['type_penugasan'] === 'ketua' });
            ketua = (ketua !== undefined) ? ketua.dosen_name.substr(0,1).toUpperCase()+ketua.dosen_name.substr(1) : '';
            return ketua;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var anggota = row.dospemSkripsiData.find((item) => { return item['type_penugasan'] === 'seketaris' });
            anggota = (anggota !== undefined) ? anggota.dosen_name.substr(0,1).toUpperCase()+anggota.dosen_name.substr(1) : '';
            return anggota;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var pembimbing1 = row.dospemUjiKelatakanData.find((item) => { return item['type_penugasan'] === 'pembimbing 1' });
            pembimbing1 = (pembimbing1 !== undefined) ? pembimbing1.dosen_name.substr(0,1).toUpperCase()+pembimbing1.dosen_name.substr(1) : '';
            return pembimbing1;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var pembimbing2 = row.dospemUjiKelatakanData.find((item) => { return item['type_penugasan'] === 'pembimbing 2' });
            pembimbing2 = (pembimbing2 !== undefined) ? pembimbing2.dosen_name.substr(0,1).toUpperCase()+pembimbing2.dosen_name.substr(1) : '';
            return pembimbing2;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var pengujiLuar = row.dospemSkripsiData.find((item) => { return item['type_penugasan'] === 'penguji luar' });
            pengujiLuar = (pengujiLuar !== undefined) ? pengujiLuar.dosen_name.substr(0,1).toUpperCase()+pengujiLuar.dosen_name.substr(1) : '';
            return pengujiLuar;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var dosenAhli = row.dospemSkripsiData.find((item) => { return item['type_penugasan'] === 'dosen ahli' });
            dosenAhli = (dosenAhli !== undefined) ? dosenAhli.dosen_name.substr(0,1).toUpperCase()+dosenAhli.dosen_name.substr(1) : '';
            return dosenAhli;
          }
      },
      { 
        "data": "judul",
        "className": "details-control cursor-pointer dt-center"
      }, 
      {
          "data": "keterangan",
          "orderable": true,
          "width" : "5",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return data;
          }
      },
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var ele = '';
            var headColumn = tableSUP.columns(11).header();

            switch(row.status) {
              case '0':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '';
                  }
                  
                break;
                case '1':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '';
                  }
                  
                break;
                case '2':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    ele = '';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    ele = '';
                  }
                break;
                case '3':
                  if (row.userRules == '1') {
                    /** Administrator */
                    ele = '';
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 10px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }

                  if (row.userRules == '4') {
                    /** Kaprodi */
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    var url = baseURL + `/jadwalSidang/details?q=${row.formulir_skripsi_id}&type=skripsi`;
                    ele = '<div>'+
                      '<div>'+
                        '<span class="badge badge-info" style="font-size: 10px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>' +
                      '</div>' +
                      '<br>' +
                      '<a href="'+ url + '" class="btn btn-outline-secondary btn-sm" target="_parent">Edit Jadwal</a>' +
                    '</div>';
                  }

                  if (row.userRules == '3') {
                    /** Dosen */
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 10px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }

                  if (row.userRules == '5') {
                    /** Mahasiswa */
                    $(headColumn).html('-');
                    ele = '<span class="badge badge-info" style="font-size: 10px;">MENUNGGU HASIL<br>PELAKSANAAN SIDANG</span>';
                  }
                break;
                case '4':
                  if (row.userRules == '4') {
                    /** Kaprodi */
                    if (row.status_kesimpulan == 1) {
                      ele = '<span class="badge badge-danger" style="font-size: 11px;">MENGULANG UJIAN</span>';
                    } else {
                      ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                    }
                  }

                  if (row.userRules == '2') {
                    /** Admin TU */
                    if (row.status_kesimpulan == 1) {
                      var url = baseURL + `/jadwalSidang/details?q=${row.formulir_skripsi_id}&type=skripsi`;
                      ele = '<div>'+
                        '<div>'+
                          '<span class="badge badge-danger" style="font-size: 10px;">MENGULANG UJIAN</span>' +
                        '</div>' +
                        '<br>' +
                        '<a href="'+ url + '" class="btn btn-outline-secondary btn-sm" target="_parent">Edit Jadwal</a>' +
                      '</div>';
                    } else {
                      ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                    }
                  }

                  if (row.userRules == '3') {
                    /** Dosen */
                    if (row.status_kesimpulan == 1) {
                      ele = '<span class="badge badge-danger" style="font-size: 11px;">MENGULANG UJIAN</span>';
                    } else {
                      ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                    }
                  }

                  if (row.userRules == '5') {
                    /** Mahasiswa */
                    if (row.status_kesimpulan == 1) {
                      ele = '<span class="badge badge-danger" style="font-size: 11px;">MENGULANG UJIAN</span>';
                    } else {
                      ele = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
                    }
                  }
                break;
              }

           return ele;
          }
      },
      // uncomment if table use expand row
      // {
      //   "data": "id",
      //   "orderable": false,
      //   "className": "dt-center",
      //   "width": "100%",
      //   render: function (data, type, row, meta) {
      //     return '<div class="box box-info">' +
      //       '<div class="box-header"></div>' +
      //       '<div class="box-body">'+ row.description +'</div>' +
      //     '</div>';
      //   }
      // }       
    ]
  });

  // $('#table-skripsi tbody').on('click', 'tr', function () {
  //   var formulir_skripsi_id = tableSkripsi.row(this).data().formulir_skripsi_id;
  //   var tempat = tableSkripsi.row(this).data().tempat;
  //   var tanggal_dan_waktu = tableSkripsi.row(this).data().tanggal_dan_waktu;

  //   var url = baseURL + `/jadwalSidang/details?q=${formulir_skripsi_id}&type=skripsi&tempat=${tempat}&tanggalWaktu=${tanggal_dan_waktu}`;
  //   return window.location.href = url;
  // });
  /** [END] - DatetTable SUP */

  /** [END] - DataTables */

  /** Onclick TAB Panel */
  $('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');

    tableSUP.columns.adjust();
    tableSkripsi.columns.adjust();
  });
  /** [END] - Onclick TAB Panel */

});

function reloadTable(_table) {
  return _table.ajax.reload(null,false);
}

function semesterFilter(e, type) {
  $('#' + type).DataTable().ajax.reload(null,false);
  return false; 
}