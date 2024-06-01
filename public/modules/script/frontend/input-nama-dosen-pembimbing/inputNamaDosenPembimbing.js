var tableInputNamaDosenPembimbing;
$(document).ready(function() {
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
  tableInputNamaDosenPembimbing = $('#tableInputNamaDosenPembimbing').DataTable({ 
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
          reloadTable(tableInputNamaDosenPembimbing);
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
          text: 'Print <i class="fa fa-file-excel-o" aria-hidden="true"></i>'
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
      "url": baseURL + "/inputNamaDosenPembimbing/getdata",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      },
      data: function (d) {
        d.semester = $('[name=semester-input-nama-dosen-pembimibing]').val();
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
          "data": "nama",
          "orderable": true,
          "className": "dt-left details-control cursor-pointer",
          render: function (data, type, row, meta) {
              return data;
          }
      },
      {
          "data": "nim",
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
        "data": "updateDate",
        "className": "dt-left details-control cursor-pointer"
      },
      {
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {

          var res = '';
          switch(row.status) {
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
                res = '<span class="badge badge-info" style="font-size: 11px;">MENUNGGU PENUGASAN<br>DOSEN DARI KAPRODI</span>';
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
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var url = baseURL + `/inputNamaDosenPembimbing/form?ujiKelayakanId=${row.id}&mahasiswaNim=${row.nim}&mahasiswaName=${row.nama}&judulProposal=${row.judul}`;
          var elements = '';

          switch(row.status) {
            case '6':
              elements = '<a href="'+ url + `&status=${row.status}` +'"  class="btn btn-outline-secondary btn-sm" target="_parent">Edit Penugasan Dosen</a>';
            break;
            case '7':
              elements = '<a href="'+ url + `&status=${row.status}` +'"  class="btn btn-outline-secondary btn-sm" target="_parent">Lihat Hasil</a>';
            break;
            default:
              elements = '<a href="'+ url + `&status=${row.status}` +'"  class="btn btn-outline-secondary btn-sm" target="_parent">Penugasan Dosen</a>';
            break;
          }
         
          return elements;
        }
      }
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