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

  /** DatetTable Uji Kelayakan Judul */
  tableUjiKelayakan = $('#table-uji-kelayakan').DataTable({ 
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRow,
        type: 'column',
        target: 'td.details-control'
      }
    },
    // oLanguage: {
    //   sProcessing: loaders
    // },
    dom: 'Bfrtip',
    buttons: [
      {
        text: 'Refresh <i class="fa fa-refresh" aria-hidden="true"></i>',
        action: function ( e, dt, node, config ) {
          reloadTable(tableUjiKelayakan);
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
          text:      '<i class="fa fa-file-excel-o"></i>',
          titleAttr: 'Excel'
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
      "url": baseURL + "/listPendaftaran/getdataUjiKelayakan",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-uji-kelayakan]').val();
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
        "data": "nama",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "nim",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "judul",
        "className": "details-control cursor-pointer"
      }, 
      { 
        "data": "tanggal_pembuatan",
        "className": "details-control cursor-pointer"
      }, 
      {
        "data": "status",
        "orderable": true,
        "width" : "50",
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var res = '';
          switch(data) {
            case '0':
              res = '<span class="badge badge-danger" style="font-size: 11px;">PENGAJUAN UJI KELAYAKAN<br>DI TOLAK</span>';
            break;
            case '1':
              res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN PENGUJI</span>';
            break;
            case '2':
              res = '<span class="badge badge-info" style="font-size: 11px;">DOSEN PENGUJI<br>SUDAH DI TUGASKAN</span>';
            break;
            case '3':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU<br>PENILAIAN DOSEN</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU<br>PENILAIAN DOSEN</span>';
              }
            break;
            case '4':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU APPROVAL</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU APPROVAL</span>';
              }
            break;
            case '5':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN PEMBIMBING</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN PEMBIMBING</span>';
              }
            break;
            case '6':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-info" style="font-size: 11px;">PENUGASAN DOSEN<br>PEMBIMBING SELESAI</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">DOSEN PEMBIMBING<br>SUDAH DI TUGASKAN</span>';
              }
            break;
            case '7':
              if (row.userRules == '1') {
                /** Administrator */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }

              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }
            break;
          }
          return res;
        }
      },   
      {
        "data": "id",
        "orderable": false,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var ele = '';
          var url = baseURL + `/listPendaftaran/details?q=${row.id}&type=uji_kelayakan`;
          
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
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Isi Penugasan</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
              
            break;
            case '2':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Edit Penugasan</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Kirim Surat Tugas</a>';
              }
            break;
            case '3':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '4':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/hasilPenilaianJudul`;
                ele = '<a href="'+ _urls +'" class="btn btn-outline-secondary btn-sm" target="_parent">Submit Approval</a>';
              }
            break;
            case '5':
              if (row.userRules == '4') {
                /** Kaprodi */
                var _urls = baseURL + `/inputNamaDosenPembimbing`;
                ele = '<a href="'+ _urls +'" class="btn btn-outline-secondary btn-sm" target="_parent">Penugasan dosen pembimbing</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '6':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '7':
              if (row.userRules == '1') {
                /** Administrator */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
              }

              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
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
  
  // $('#table-uji-kelayakan tbody').on('click', 'tr', function () {
  //   var id = tableUjiKelayakan.row(this).data().id;
  //   var url = baseURL + `/listPendaftaran/details?q=${id}&type=uji_kelayakan`;
  //   return window.location.href = url;
  // });

  /** [END] - DatetTable Uji Kelayakan Judul */


  /** DatetTable SUP */
  tableSUP = $('#table-sup').DataTable({ 
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRow,
        type: 'column',
        target: 'td.details-control'
      }
    },
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
          text:      '<i class="fa fa-file-excel-o"></i>',
          titleAttr: 'Excel'
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
      "url": baseURL + "/listPendaftaran/getdataSUP",
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
        "data": "nama",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "nim",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "judul",
        "className": "details-control cursor-pointer"
      }, 
      { 
        "data": "tanggal_pembuatan",
        "className": "details-control cursor-pointer"
      }, 
      {
        "data": "status",
        "orderable": true,
        "width" : "50",
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var res = '';
          switch(data) {
            case '0':
              res = '<span class="badge badge-danger" style="font-size: 11px;">PENGAJUAN UJI KELAYAKAN<br>DI TOLAK</span>';
            break;
            case '1':
              res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN PENGUJI</span>';
            break;
            case '2':
              res = '<span class="badge badge-info" style="font-size: 11px;">DOSEN PENGUJI<br>SUDAH DI TUGASKAN</span>';
            break;
            case '3':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-info" style="font-size: 11px;">JADWAL SUDAH DI BUAT</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">JADWAL SUDAH DI BUAT</span>';
              }
            break;
            case '4':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }
            break;
            case '5':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '';
              }
            break;
            case '6':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '';
              }
            break;
            case '7':
              if (row.userRules == '1') {
                /** Administrator */
                res = '';
              }

              if (row.userRules == '4') {
                /** Kaprodi */
                res = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '';
              }
            break;
          }
          return res;
        }
      }, 
      {
        "data": "id",
        "orderable": false,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var ele = '';
          var url = baseURL + `/listPendaftaran/details?q=${row.id}&type=sup`;
          
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
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Isi Penugasan</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
              
            break;
            case '2':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Edit Penugasan</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/inputJadwal`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Isi Input Jadwal</a>';
              }
            break;
            case '3':
              if (row.userRules == '4') {
                /** Kaprodi */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }
            break;
            case '4':
              if (row.userRules == '4') {
                /** Kaprodi */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }
            break;
            case '5':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '6':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '7':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
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

/*  $('#table-sup tbody').on('click', 'tr', function () {
    var id = tableSUP.row(this).data().id;
    var url = baseURL + `/listPendaftaran/details?q=${id}&type=sup`;
    return window.location.href = url;
  });*/
  /** [END] - DatetTable SUP */

  /** DatetTable Skripsi */
  tableSkripsi = $('#table-skripsi').DataTable({ 
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRow,
        type: 'column',
        target: 'td.details-control'
      }
    },
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
          text:      '<i class="fa fa-file-excel-o"></i>',
          titleAttr: 'Excel'
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
      "url": baseURL + "/listPendaftaran/getdataSkripsi",
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
        "data": "nama",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "nim",
        "className": "details-control cursor-pointer"
      },
      { 
        "data": "judul",
        "className": "details-control cursor-pointer"
      },      
      { 
        "data": "tanggal_pembuatan",
        "className": "details-control cursor-pointer"
      }, 
     {
        "data": "status",
        "orderable": true,
        "width" : "50",
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var res = '';
          switch(data) {
            case '0':
              res = '<span class="badge badge-danger" style="font-size: 11px;">PENGAJUAN UJI KELAYAKAN<br>DI TOLAK</span>';
            break;
            case '1':
              res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN PENGUJI</span>';
            break;
            case '2':
              res = '<span class="badge badge-info" style="font-size: 11px;">DOSEN PENGUJI<br>SUDAH DI TUGASKAN</span>';
            break;
            case '3':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-info" style="font-size: 11px;">JADWAL SUDAH DI BUAT</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">JADWAL SUDAH DI BUAT</span>';
              }
            break;
            case '4':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-success" style="font-size: 11px;">SELESAI</span>';
              }
            break;
            case '5':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '';
              }
            break;
            case '6':
              if (row.userRules == '4') {
                /** Kaprodi */
                res = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '';
              }
            break;
            case '7':
              if (row.userRules == '1') {
                /** Administrator */
                res = '';
              }

              if (row.userRules == '4') {
                /** Kaprodi */
                res = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '';
              }
            break;
          }
          return res;
        }
      }, 
      {
        "data": "id",
        "orderable": false,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var ele = '';
          var url = baseURL + `/listPendaftaran/details?q=${row.id}&type=skripsi`;
          
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
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Isi Penugasan</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
              
            break;
            case '2':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Edit Penugasan</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/inputJadwal`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Isi Input Jadwal</a>';
              }
            break;
            case '3':
              if (row.userRules == '4') {
                /** Kaprodi */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }
            break;
            case '4':
              if (row.userRules == '4') {
                /** Kaprodi */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                var _urls = baseURL + `/jadwalSidang`;
                ele = '<a href="'+ _urls + '" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Jadwal</a>';
              }
            break;
            case '5':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '6':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
              }
            break;
            case '7':
              if (row.userRules == '4') {
                /** Kaprodi */
                ele = '';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                ele = '';
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
  //   var id = tableSkripsi.row(this).data().id;
  //   var url = baseURL + `/listPendaftaran/details?q=${id}&type=skripsi`;
  //   return window.location.href = url;
  // });
  /** [END] - DatetTable SUP */

  /** [END] - DataTables */

  /** Onclick TAB Panel */
  $('#myTab a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');

    tableUjiKelayakan.columns.adjust();
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