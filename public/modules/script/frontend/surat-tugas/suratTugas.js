var tableSuratTugas;
var tableSuratTugasPembimbing;
var theColumns;
$(document).ready(function() {
  tableDataSuratTugasPembimbing();

 	/** DataTables */
  	var loaders = "<div style='background-color: #fff;'>" +
                  "<img class='loader-icon' src='"+ (baseURL + '/files/loaderImg?loader=loader-image-data-table') +"' style='width: 50%;'>" +
                  "<div><h4>Loading...</h4></div>" +
                "</div>";

	/** Handler Error Ajax Call DataTables */
	$.fn.dataTable.ext.errMode = function (settings, helpPage, message) { 
		console.log({
		  url: settings.ajax.url,
		  type: settings.ajax.type,
		  columns: settings.oInit.columns,
		  errors: message
		});
	};       
	/** [END] - Handler Error Ajax Call DataTables */

  var __rules = $('[name=rules]').val();

  theColumns = [
      {
          "data": "id",
          "orderable": true,
          "width" : "5%",
          "className": "dt-center details-control",
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1 + '.';
          }
      },
      {
          "data": "assigment_to_username",
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
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var urlFIle = '';

          if ($('[name=rules]').val() == 3) {
            urlFIle = (baseURL + '/files/document?q=' + row.surat_tugas_to_dosen_files + '&mode=view');
          }

          if ($('[name=rules]').val() == 5) {
            urlFIle = (baseURL + '/files/document?q=' + row.surat_tugas_to_mahasiswa_files + '&mode=view');
          }
            
            var html = '<div class="btn-group">' +
                    '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="downloadFile(\''+urlFIle+'\');" title="Cetak File">' +
                      'Cetak' +
                    '</button>' +
                  '</div>';
          return html;
        }
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
              if ($('[name=rules]').val() == 3) {
                res = '<span class="badge badge-danger" style="font-size: 11px;"><span class="badge badge-success" style="font-size: 11px;">PENILAIAN SELESAI</span> & PENGAJUAN<br>DI TOLAK</span>';
              }

              if ($('[name=rules]').val() == 5) {
                res = '<span class="badge badge-danger" style="font-size: 11px;">PENGAJUAN UJI KELAYAKAN<br>DI TOLAK</span>';
              }
            break;
            case '1':
              if ($('[name=rules]').val() == 3) {
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU<br>PENILAIAN DOSEN</span>';
              }

              if ($('[name=rules]').val() == 5) {
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU<br>PENILAIAN DOSEN</span>';
              }
            break;
            case '2':
              if ($('[name=rules]').val() == 3) {
                res = '<span class="badge badge-success" style="font-size: 11px;">PENILAIAN SELESAI</span>';
              }

              if ($('[name=rules]').val() == 5) {
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU APPROVAL</span>';
              }
             
            break;
            case '3':
               if ($('[name=rules]').val() == 3) {
                res = '';
              }

              if ($('[name=rules]').val() == 5) {
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN PEMBIMBING</span>';
              }
            break;
            case '4':
               if ($('[name=rules]').val() == 3) {
                res = '';
              }

              if ($('[name=rules]').val() == 5) {
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU<br>SURAT TUGAS BIMBINGAN</span>';
              }
            break;
            case '5':
               if ($('[name=rules]').val() == 3) {
                res = '';
              }

              if ($('[name=rules]').val() == 5) {
                res = '<span class="badge badge-success" style="font-size: 11px;">APPROVED</span>';
              }
            break;
          }
          return res;
        }
      },   
    ];

  if($.inArray(__rules, ['1', '2', '3', '4']) !== -1 ) {
    theColumns.splice(5, 0, {
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var urlFIle = '';
          urlFIle = (baseURL + '/files/document?q=' + row.mahasiswa_proposal_file_form_uji_kelayakan + '&mode=view');
            
          var html = '<div class="btn-group">' +
                    '<button type="button" class="btn btn-primary btn-sm btn-col-navy" onclick="downloadFile(\''+urlFIle+'\');" title="Cetak File">' +
                      'Cetak' +
                    '</button>' +
                  '</div>';
          return html;
        }
      });

      theColumns.splice(8, 0, {
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var url = baseURL + `/suratTugas/penilaianForm?dosenId=${row.assigment_to_user_id}&mhsId=${row.mahasiswa_id}&ujiKelayakanId=${row.uji_kelayakan_id}`;
          var elements = '';
          
          switch(row.status) {
          case '0':
              elements = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
            break;
            case '1':
              elements = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Isi Penilaian</a>';
            break;
            case '2':
              elements = '<a href="'+ url + `&status=${row.status}` +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
            break;
            case '3':
              res = '';
            break;
          }
          return elements;
        }
      });
  }

   if($.inArray(__rules, ['5']) !== -1 ) {
     theColumns.splice(8, 0, {
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var url = baseURL + `/suratTugas/hasilPenilaian?mhsId=${row.mahasiswa_id}&ujiKelayakanId=${row.uji_kelayakan_id}`;
          var elements = '';
          
          if (row.mahasiswa_hasil_penilaian_result) {
            elements = '<a href="'+ url +'" class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
          }
          
          return elements;
        }
      });
   }

  /** DatetTable Surat Tugas */
  tableSuratTugas = $('#tableSuratTugas').DataTable({ 
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
          reloadTable(tableSuratTugas);
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
      "url": baseURL + "/suratTugas/getdata",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-surat-tugas]').val();
      },         
    },
    "initComplete": function(settings, json) {
      lazyLoadImg('lazy-load-img');
      // console.log('initComplete');
    },
    //Set column definition initialisation properties.
    "columns": theColumns
  });
  /** [END] - DatetTable Surat Tugas */

});

function tableDataSuratTugasPembimbing() {
  /** DataTables */
  var loaders = "<div style='background-color: #fff;'>" +
                "<img class='loader-icon' src='"+ (baseURL + '/files/loaderImg?loader=loader-image-data-table') +"' style='width: 50%;'>" +
                "<div><h4>Loading...</h4></div>" +
              "</div>";

  /** Handler Error Ajax Call DataTables */
  $.fn.dataTable.ext.errMode = function (settings, helpPage, message) { 
    console.log({
      url: settings.ajax.url,
      type: settings.ajax.type,
      columns: settings.oInit.columns,
      errors: message
    });
  };       
  /** [END] - Handler Error Ajax Call DataTables */

  /** DatetTable Surat Tugas */
  tableSuratTugasPembimbing = $('#tableSuratTugasPembimbing').DataTable({ 
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
          reloadTable(tableSuratTugasPembimbing);
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
      "url": baseURL + "/suratTugas/getdataPembimbing",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-surat-tugas-bimbingan]').val();
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
          "width" : "5%",
          "className": "dt-center details-control",
          render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1 + '.';
          }
      },
      {
          "data": "assigment_to_username",
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
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var urlFIle = '';
          if ($('[name=rules]').val() == 3) {
            urlFIle = (baseURL + '/files/document?q=' + row.surat_tugas_to_dosen_files + '&mode=view');
          }

          if ($('[name=rules]').val() == 5) {
            urlFIle = (baseURL + '/files/document?q=' + row.surat_tugas_to_mahasiswa_files + '&mode=view');
          }
            
            var html = '<div class="btn-group">' +
                    '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="downloadFile(\''+urlFIle+'\');" title="Cetak File">' +
                      'Cetak' +
                    '</button>' +
                  '</div>';
          return html;
        }
      }
    ]
  });
  /** [END] - DatetTable Surat Tugas */
  return false;
}


function reloadTable(_table) {
  return _table.ajax.reload(null,false);
}

function downloadFile(url) {
  return window.open(url, "popupWindow", "width=700,height=700,scrollbars=yes");
}

function semesterFilter(e, type) {
  $('#' + type).DataTable().ajax.reload(null,false);
  return false; 
}