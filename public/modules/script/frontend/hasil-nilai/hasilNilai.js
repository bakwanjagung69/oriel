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
      "url": baseURL + "/hasilNilai/getdataSUP",
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
          "data": "input_jadwal_id",
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
          "data": "input_jadwal_id",
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
        "data": "judul",
        "className": "details-control cursor-pointer dt-center"
      }, 
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var res = '';
            switch (row.userRules) {
              case '2':
                // ADMIN TU
                res = row.resultGrade;
              break;
              case '3':
                // DOSEN
                res = row.resultGradePerDosen;
              break;
            case '5':
                // Mahasiswa
                res = row.resultGrade;
              break;
            }
            return res;
          }
      },
      {
          "data": "input_jadwal_id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var ele = '';
            var url = baseURL + `/hasilNilai/details?q=${row.formulir_sup_id}&type=sup&jadwalInputNilaiId=${row.input_jadwal_id}`;
            ele = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil Nilai</a>';

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
  //   var input_jadwal_id = tableSUP.row(this).data().id;
  //   var formulir_sup_id = tableSUP.row(this).data().formulir_sup_id;

  //   var tempat = tableSUP.row(this).data().tempat;
  //   var tanggal_dan_waktu = tableSUP.row(this).data().tanggal_dan_waktu;

  //   var url = baseURL + `/hasilNilai/details?q=${formulir_sup_id}&type=sup&tempat=${tempat}&tanggalWaktu=${tanggal_dan_waktu}&jadwalId=${input_jadwal_id}`;
  //   return window.location.href = url;
  // });
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
      "url": baseURL + "/hasilNilai/getdataSkripsi",
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
        "data": "judul",
        "className": "details-control cursor-pointer dt-center"
      }, 
      {
          "data": "id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var res = '';
            switch (row.userRules) {
              case '2':
                // ADMIN TU
                res = row.resultGrade;
              break;
              case '3':
                // DOSEN
                res = row.resultGradePerDosen;
              break;
            case '5':
                // Mahasiswa
                res = row.resultGrade;
              break;
            }
            return res;
          }
      },
      {
          "data": "input_jadwal_id",
          "orderable": true,
          "width" : "150",
          "className": "dt-center details-control cursor-pointer",
          render: function (data, type, row, meta) {
            var ele = '';
            var url = baseURL + `/hasilNilai/details?q=${row.formulir_skripsi_id}&type=skripsi&jadwalInputNilaiId=${row.input_jadwal_id}`;
            ele = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil Nilai</a>';

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
  //   var input_jadwal_id = tableSkripsi.row(this).data().id;
  //   var formulir_skripsi_id = tableSkripsi.row(this).data().formulir_skripsi_id;

  //   var tempat = tableSkripsi.row(this).data().tempat;
  //   var tanggal_dan_waktu = tableSkripsi.row(this).data().tanggal_dan_waktu;

  //   var url = baseURL + `/hasilNilai/details?q=${formulir_skripsi_id}&type=skripsi&tempat=${tempat}&tanggalWaktu=${tanggal_dan_waktu}&jadwalId=${input_jadwal_id}`;
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