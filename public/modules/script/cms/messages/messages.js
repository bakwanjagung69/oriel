var table;
$( document ).ready(function() {

  const urlSearchParams = new URLSearchParams(window.location.search);
  const params = Object.fromEntries(urlSearchParams.entries());

  var checkURL = (Object.keys(params).length === 0);
  if (checkURL) {
    var url = baseURL +'/admin/messages?q=inbox';
    window.location.href = url;
    return false;
  }

  if (params.q == 'sent') {
    /** Notfy for if table can expand row */
    Pnotify(
      'Info!', 
      'Click the table row to expand the content.', 
      3000, 
      '#337ab7'
    );
    /** [END] - Notfy for if table can expand row */
  }

  /** DataTables */
  var loaders = "<div style='background-color: #fff;'>" +
                  "<img class='loader-icon' src='"+ (baseURL + '/assets/cms/dataTable-responsive/images/Infinity-1s-200px.svg') +"' style='width: 50%;'>" +
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

  var elColumnDataTable; 
  if (params.q == 'sent') {
    elColumnDataTable = [
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
        "data": "name",
        "orderable": true,
        "className": "details-control",
        render: function (data, type, row, meta) {
          var html = '';
          if (row.reading_status !== '2') {
            html = '<a href="javascript:void(0);" onclick="ReadMail(\''+ row.uuid + '\');">'+ data +'</a>';
          } else {
            html = data;
          }
          return html;
        }
      },    
      { 
        "data": "email",
        "className": "details-control"
      },
      {
        "data": "sendDate",
        "orderable": true,
        "className": "details-control",
        render: function (data, type, row, meta) {
          return data;
        }
      },
      {
        "data": "reading_status",
        "orderable": true,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var read = '';
          if (data == '0') {
            read = '<i class="fa fa-envelope-o" style="color: #ff1b1b;font-weight: bold;"></i>';
          }
          if (data == '1') {
            read = '<i class="fa fa-envelope-open-o" style="color: #3c8dbc;font-weight: bold;"></i>';
          }
          if (data == '2') {
            read = '<i class="fa fa-check-circle" style="color: #337ab7;font-weight: bold;"></i>';
          }
          return read;
        }
      },          
      {
        "data": "id",
        "orderable": false,
        "width": "8%",
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var id = row.id;
          var uuid = row.uuid;          
            
          var html = '';
          if (row.reading_status !== '2') {
            html += '<div class="btn-group">' +
            '<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply" data-original-title="Reply" onclick="Reply(\''+uuid+'\');">' +
              '<i class="fa fa-reply" aria-hidden="true"></i>' +
            '</button>';
          }
          html += '<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete" data-original-title="Delete" onclick="Delete('+id+');">' +
            '<i class="fa fa-trash" aria-hidden="true"></i>' +
          '</button>' +
        '</div>';
        return html;
        }
      }, 
      {
        "data": "id",
        "orderable": false,
        "className": "dt-center",
        render: function (data, type, row, meta) {
          return '<div class="box box-info">' +
            '<div class="box-header"></div>' +
            '<div class="box-body">'+ row.message +'</div>' +
          '</div>';
        }
      }                                       
    ];
  } else {
    elColumnDataTable = [
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
        "data": "name",
        "orderable": true,
        "className": "details-control",
        render: function (data, type, row, meta) {
          var html = '';
          if (row.reading_status !== '2') {
            html = '<a href="javascript:void(0);" onclick="ReadMail(\''+ row.uuid + '\');">'+ data +'</a>';
          } else {
            html = data;
          }
          return html;
        }
      },    
      { 
        "data": "email",
        "width" : "10%",
        "className": "details-control"
      },
      {
        "data": "message",
        "width" : "25%",
        "orderable": false,
        "className": "details-control",
        render: function (data, type, row, meta) {
          var str = data.replace( /(<([^>]+)>)/ig, '');
          var dispString = (str.length >= 39) ? str.slice(0, 39) + '...' : str;
          return dispString;
        }
      },      
      {
        "data": "sendDate",
        "orderable": true,
        "className": "details-control",
        render: function (data, type, row, meta) {
          return data;
        }
      },
      {
        "data": "reading_status",
        "orderable": true,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          var read = '';
          if (data == '0') {
            read = '<i class="fa fa-envelope-o" style="color: #ff1b1b;font-weight: bold;"></i>';
          }
          if (data == '1') {
            read = '<i class="fa fa-envelope-open-o" style="color: #3c8dbc;font-weight: bold;"></i>';
          }
          if (data == '2') {
            read = '<i class="fa fa-check-circle" style="color: #337ab7;font-weight: bold;"></i>';
          }
          return read;
        }
      },          
      {
        "data": "id",
        "orderable": false,
        "width": "8%",
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var id = row.id;
          var uuid = row.uuid;          
            
          var html = '';
          if (row.reading_status !== '2') {
            html += '<div class="btn-group">' +
            '<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Reply" data-original-title="Reply" onclick="Reply(\''+uuid+'\');">' +
              '<i class="fa fa-reply" aria-hidden="true"></i>' +
            '</button>';
          }
          html += '<button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Delete" data-original-title="Delete" onclick="Delete('+id+');">' +
            '<i class="fa fa-trash" aria-hidden="true"></i>' +
          '</button>' +
        '</div>';
        return html;
        }
      },                                        
    ];
  }

  table = $('#table').DataTable({ 
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
        text: '<i class="fa fa-plus-circle" aria-hidden="true"></i> Compose',
        action: function ( e, dt, node, config ) {
          composeMail();
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
      {
          extend:    'csvHtml5',
          text:      '<i class="fa fa-file-text-o"></i>',
          titleAttr: 'CSV'
      },
      {
          extend:    'pdfHtml5',
          text:      '<i class="fa fa-file-pdf-o"></i>',
          titleAttr: 'PDF'
      },
  ],
    "processing": true,
    "serverSide": true,
    "order": [], 
    "ajax": {
      "url": baseURL + "/admin/messages/getdata?q=" + params.q,
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
    "columns": elColumnDataTable
  });
  // Add event listener for opening and closing details
  // $('#table tbody').on('click', 'td.details-control', function(){
  //     var tr = $(this).closest('tr');
  //     var row = table.row( tr );

  //     if(row.child.isShown()){
  //         // This row is already open - close it
  //         row.child.hide();
  //         tr.removeClass('shown');
  //     } else {
  //         // Open this row 
  //         row.child(expandRow(row.data())).show();
  //         tr.addClass('shown');
  //     }
  // });

  function expandRow(data) {
    return;
  }

  /** [END] - DataTables */

});

function reloadTable() {
  return table.ajax.reload(null,false);
}

function composeMail() {
  var url = baseURL +'/admin/messages/compose' + window.location.search;
  return window.location.href = url;
}

function ReadMail(uuid) {
  var url = baseURL +'/admin/messages/readmail/' + uuid + window.location.search;
  return window.location.href = url;
}

function Reply(uuid) {
  var url = baseURL +'/admin/messages/reply/' + uuid + window.location.search;
  return window.location.href = url;
}

function Delete(id) {
  var url = baseURL +'/admin/messages/delete' + window.location.search;

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
              type: "POST",
              data: {"id" : id},
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