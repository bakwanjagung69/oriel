var table;
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

  table = $('#table').DataTable({ 
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
        text: '<i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data',
        action: function ( e, dt, node, config ) {
          formNewData();
        }
      },
      {
        text: 'Refresh <i class="fa fa-refresh" aria-hidden="true"></i>',
        action: function ( e, dt, node, config ) {
          reloadTable();
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
          messageTop: 'Data semester',
          text: 'Print <i class="fa fa-print" aria-hidden="true"></i>'
      },
      {
          extend:    'copyHtml5',
          text:      '<i class="fa fa-files-o"></i>',
          titleAttr: 'Copy'
      },
     /* {
          extend:    'excelHtml5',
          text:      '<i class="fa fa-file-excel-o"></i>',
          titleAttr: 'Excel'
      },
      {
          extend:    'csvHtml5',
          text:      '<i class="fa fa-file-text-o"></i>',
          titleAttr: 'CSV'
      },
      {
          extend:    'pdfHtml5',
          text:      '<i class="fa fa-file-pdf-o"></i>',
          titleAttr: 'PDF'
      },*/
  ],
    "processing": true,
    "serverSide": true,
    "order": [], 
    "ajax": {
      "url": baseURL + "/semester/getdata",
      "type": "POST",
      "dataType": "JSON",
      "dataSrc": function ( json ) {
        // console.log('Load Complete!');
        lazyLoadImg('lazy-load-img');
        return json.data;
      }       
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
        "data": "angkatan",
        "className": "details-control"
      },
      { 
        "data": "dari_tahun",
        "className": "details-control"
      },
      { 
        "data": "sampai_tahun",
        "className": "details-control"
      }, 
      { 
        "data": "semester",
        "className": "details-control"
      },          
      {
        "data": "status",
        "orderable": true,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var res = (data == '1') ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
          return res;
        }
      },
      {
        "data": "id",
        "orderable": false,
        "width": "8%",
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var id = row.id;
          var html = '<div class="btn-group">' +
                    '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="formEdit(\''+id+'\');" title="Edit data">' +
                      '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-outline-secondary btn-sm" onclick="Delete(\''+id+'\');" title="Delete data">' +
                      '<i class="fa fa-trash" aria-hidden="true"></i>' +
                    '</button>' +
                  '</div>';
        return html;
        }
      }
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
  /** [END] - DataTables */

});

function reloadTable() {
  return table.ajax.reload(null,false);
}

function formNewData() {
  var url = baseURL +'/semester/form';
  return window.location.href = url;
}

function formEdit(id) {
  var url = baseURL +'/semester/form/edit?q=' + id;
  return window.location.href = url;
}

function Delete(id) {
  var url = baseURL +'/semester/delete?q=' + id;

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
                setTimeout(function() {
                  reloadTable();
                }, 800);
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
}