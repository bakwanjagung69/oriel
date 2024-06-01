var tableHasilPenilaianJudul;
$(document).ready(function() {
    /** DatetTable Surat Tugas */
    var loaders = "<div style='background-color: #fff;'>" +
      "<img class='loader-icon' src='"+ (baseURL + '/files/loaderImg?loader=loader-image-data-table') +"' style='width: 50%;'>" +
      "<div><h4>Loading...</h4></div>" +
    "</div>";

  tableHasilPenilaianJudul = $('#tableHasilPenilaianJudul').DataTable({ 
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.childRow,
        type: 'column',
        target: 'td.details-control'
      }
    },
    oLanguage: {
      sProcessing: loaders
    },
    dom: 'Bfrtip',
    buttons: [
      {
        text: 'Refresh <i class="fa fa-refresh" aria-hidden="true"></i>',
        action: function ( e, dt, node, config ) {
          reloadTable(tableHasilPenilaianJudul);
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
      "url": baseURL + "/hasilPenilaianJudul/getdata",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-hasil-penilaian-judul]').val();
      },          
    },
    "initComplete": function(settings, json) {
      lazyLoadImg('lazy-load-img');
      // console.log('initComplete');
    },
    //Set column definition initialisation properties.
    "columns": [
      {
          "data": "uji_kelayakan_id",
          "orderable": true,
          "width" : "5%",
          "className": "dt-center details-control",
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1 + '.';
          }
      },
      {
          "data": "mahasiswa_name",
          "orderable": true,
          "className": "dt-left details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return data;
          }
      },
      {
          "data": "mahasiswa_nim",
          "orderable": true,
          "className": "dt-left details-control cursor-pointer",
          render: function (data, type, row, meta) {
            return data;
          }
      },
      { 
        "data": "judul",
        "className": "dt-left details-control cursor-pointer"
      },
      {
          "data": "createDate",
          "orderable": true,
          "className": "dt-left details-control cursor-pointer",
          render: function (data, type, row, meta) {
            return data;
          }
      },
      {
        "data": "uji_kelayakan_id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
           var res = '';
          switch(row.status) {
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
                res = '<span class="badge badge-info" style="font-size: 11px;">PENILAIAN DOSEN SELESAI</span>';
              }

              if (row.userRules == '2') {
                /** Admin TU */
                res = '<span class="badge badge-info" style="font-size: 11px;">PENILAIAN DOSEN SELESAI</span>';
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
        "data": "uji_kelayakan_id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var elements = '';
          var url = '';
          var headColumn = tableHasilPenilaianJudul.columns(6).header();

          switch(row.status) {
          case '0':
              $(headColumn).html('---');
              elements = '';
            break;
            case '1':
              elements = '';
            break;
            case '2':
              elements = '';
            break;
            case '3':
              if (row.userRules == '2') {
                /** Admin TU */
                url = baseURL + `/hasilPenilaianJudul/hasilPenilaian?mhsId=${row.mahasiswa_id}&ujiKelayakanId=${row.uji_kelayakan_id}&statusPenugasan=1&status=${row.status}`;
                $(headColumn).html('Lihat Hasil');
                elements = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
              }

              if (row.userRules == '4') {
                /** Kaprodi */
                elements = '';
              }
            break;
            case '4':
              if (row.userRules == '2') {
                url = baseURL + `/hasilPenilaianJudul/hasilPenilaian?mhsId=${row.mahasiswa_id}&ujiKelayakanId=${row.uji_kelayakan_id}&statusPenugasan=1&status=${row.status}`;
                $(headColumn).html('Lihat Hasil');
                elements = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Klik Lanjut</a>';
              }              
            break;
            case '5':
              elements = '';
            break;
            case '6':
                if (row.userRules == '2') {
                /** Admin TU */
                url = baseURL + `/hasilPenilaianJudul/hasilPenilaian?mhsId=${row.mahasiswa_id}&ujiKelayakanId=${row.uji_kelayakan_id}&statusPenugasan=2&status=${row.status}`;
                $(headColumn).html('Lihat Hasil & Kirim surat Tugas');
                elements = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil & Kirim surat Tugas</a>';
              }  
            break;
            case '7':
              url = baseURL + `/hasilPenilaianJudul/hasilPenilaian?mhsId=${row.mahasiswa_id}&ujiKelayakanId=${row.uji_kelayakan_id}&statusPenugasan=1&status=${row.status}`;
              $(headColumn).html('Lihat Hasil');
              elements = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
            break;
          }

          return elements;
        }
      },
    ]
  });
  /** [END] - DatetTable Surat Tugas */
});

function reloadTable(_table) {
  return _table.ajax.reload(null,false);
}

function downloadFile(url) {
  return window.open(url);
}

function semesterFilter(e, type) {
  $('#' + type).DataTable().ajax.reload(null,false);
  return false; 
}