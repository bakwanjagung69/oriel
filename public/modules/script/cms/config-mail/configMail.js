var table;
$( document ).ready(function() {

  /** Notfy for if table can expand row */
  Pnotify(
    'Info!', 
    'Click the table row to expand the content.', 
    3000, 
    '#337ab7'
  );
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
    oLanguage: {
      sProcessing: loaders
    },
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
      "url": baseURL + "/admin/configMail/getdata",
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
          "defaultContent": '',
          "className": "dt-center details-control",
          render: function (data, type, row, meta) {
              return (meta.row + meta.settings._iDisplayStart + 1 + '.');
          }
      },
      {
        "data": "id",
        "orderable": false,
        "width" : "20%",
        "className": "dt-center",
        render: function (data, type, row, meta) {
          var uriThumnails = (baseURL + '/files/images?q=' + row.thumbnail_logo);
          var uriImages    = (baseURL + '/files/images?q=' + row.logo);

          var loaderImg =  (baseURL + '/files/loaderImg?loader=loader-image');
          return '<a href="'+ uriImages +'" target="_blank">'+
                  '<img class="img-thumbnail lazy-load-img" src="'+ loaderImg +'" data-src="'+ uriThumnails +'" width="80" height="80" />'
            '</a>';
        }
      },
      { 
        "data": "email_name",
        "className": "details-control"
      },
      { 
        "data": "subject_email",
        "className": "details-control"
      },                     
      {
        "data": "status",
        "orderable": false,
        "className": "dt-center details-control",
        render: function (data, type, row, meta) {
          if (row.status == 'active') {
            return '<span class="label bg-green">Active</span>';
          } else {
            return '<span class="label bg-red">Inactive</span>';
          }
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
                    '<button type="button" class="btn btn-default btn-sm" onclick="formEdit(\''+id+'\');" title="Edit data">' +
                      '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>' +
                    '</button>' +
                    '<button type="button" class="btn btn-default btn-sm" onclick="Delete(\''+id+'\');" title="Delete data">' +
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
        "width": "100%",
        render: function (data, type, row, meta) {
          var el = '<div class="box box-info">' +
            '<div class="box-header"></div>' +
            '<div class="box-body">'+
              '<table style="width: 100%;">' +
                '<tr>' +
                  '<td class="textBold">Main Email</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.main_email +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Body Email To</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td><div class="disp-bodyMail">'+ row.body_email_to +'</div></td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Email Received</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.email_received +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Body Email Received</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td><div class="disp-bodyMail">'+ row.body_email_received +'</div></td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Email CC</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.email_cc +'</td>' +
                '</tr>' +
                 '<tr>' +
                  '<td class="textBold">Mail Type</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.mail_type +'</td>' +
                '</tr>' +
                 '<tr>' +
                  '<td class="textBold">Reply To Mail</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.reply_to_email +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Reply To Email Name</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.reply_to_email_name +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Protocol</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.protocol +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Host</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.host +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Username</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.username +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Password</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.password +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Port</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.port +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Charset</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.charset +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Timeout</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.timeout +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">Validation</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.validation +'</td>' +
                '</tr>' +
                '<tr>' +
                  '<td class="textBold">WordWrap</td>' +
                  '<td class="dots textBold">:</td>' +
                  '<td>'+ row.wordwrap +'</td>' +
                '</tr>' +
             '</table>' +
             '<br><br>' +
             '<hr>' +
             '<div class="sosmed">' +
                '<h3>Social Media</h3>' +
                '<table class="table table-bordered">' +
                  '<tr>'+
                    '<th>Icon</th>' +
                    '<th>Name</th>' +
                    '<th>URL</th>' +
                  '</tr>';        
                  var __dataSosmed = JSON.parse(row.social_media);
                  if (__dataSosmed !== null) {
                    for (var i = 0; i < __dataSosmed.length; i++) {
                      el += '<tr>' +
                            '<td><i class="fa fa-3x">&#x'+ __dataSosmed[i].iconSosmed +'</i></td>' +
                            '<td>'+ __dataSosmed[i].sosmedName +'</td>' +
                            '<td>'+ __dataSosmed[i].urlSodmed +'</td>';
                      el += '</tr>';
                    }        
                  }             
              el += '</table>' +
             '</div>' +
            '</div>' +
          '</div>';

          return el;
        }
      },        
    ]
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

function formNewData() {
  var url = baseURL +'/admin/configMail/form';
  return window.location.href = url;
}

function formEdit(id) {
  var url = baseURL +'/admin/configMail/form/edit?q=' + id;
  return window.location.href = url;
}

function Delete(id) {
  var url = baseURL +'/admin/configMail/delete?q=' + id;

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