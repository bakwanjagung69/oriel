$(document).ready(function() {
  getData($('#userId').val());

  /** Preview Image */
  $(document).on('click', '#close-preview', function(){ 
      $('.image-preview').popover('hide');
      // Hover befor close the preview
      $('.image-preview').hover(
          function () {
             $('.image-preview').popover('show');
          }, 
           function () {
             $('.image-preview').popover('hide');
          }
      );    
  });

  var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
    /** [END] Preview Image */

    /** Show Hide Password */
    $('.showHide').click(function(event) {
      var attrData = $(event.target).attr('data-showHide');
      var elInputPass = event.target.parentElement.nextElementSibling;
      if (attrData == '0') {
        $(event.target).text('hide').attr('data-showHide', '1');
        $(elInputPass).attr('type', 'text');
      } else {
        $(event.target).text('show').attr('data-showHide', '0');
        $(elInputPass).attr('type', 'password');
      }
    });
    /** [END] Show Hide Password */
});

function showModal() {
  $('#modal-default').modal('show');
}

function getData(userId) {
  var url = baseURL +'/admin/profile/getdatabyid';

  $.ajax({
    url : url,    
    type: "POST",
    data: {"userId" : userId},
    dataType: "JSON",
    success: function(data) {
      $('input[name=full_name]').val(data.full_name);
      $('#userName').val(data.username);
      $('input[name=email]').val(data.email);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });
}

function changePassword() {
  $('.loaders-changePass').replaceWith('<i class="fa fa-spinner fa-pulse fa-fw loaders-changePass"></i>');

  var newPass    = $('input[name=new_password]').val();
  var confimPass = $('input[name=confirm_password]').val(); 

  var valid = true;

  if (newPass == '') {
    var parrentEl = $('input[name=new_password]').parent();
    $(parrentEl).addClass('has-error');
    valid = false;
  }

  if (confimPass == '') {
    var parrentEl = $('input[name=confirm_password]').parent();
    $(parrentEl).addClass('has-error');
    valid = false;
  }

  if (newPass !== '') {
    var parrentEl = $('input[name=new_password]').parent();
    $(parrentEl).removeClass('has-error');
    valid = true;
  }

  if (confimPass !== '') {
    var parrentEl = $('input[name=confirm_password]').parent();
    $(parrentEl).removeClass('has-error');
    valid = true;
  }

  if (!valid) {
    $('.loaders-changePass').replaceWith('<i class="fa fa-floppy-o loaders-changePass">');
    return false;
  }

  if (newPass !== confimPass) {
    $('.loaders-changePass').replaceWith('<i class="fa fa-floppy-o loaders-changePass">');
    var elConfimPass = $('input[name=confirm_password]').prev()[0].parentElement;
    $(elConfimPass).addClass('has-error');

    $.confirm({
     title: 'Error!',
     content: 'Confirm Password not match!',
     type: 'red',
     typeAnimated: true,
     buttons: {
      btnSave: {
        text: 'OK',
        btnClass: 'btn-red',
        action: function(event) {}
      },
        close: function(error) {}
     }
    });
    return false;
  } else {
    var elConfimPass = $('input[name=confirm_password]').prev()[0].parentElement;
    $(elConfimPass).removeClass('has-error');
  }

  var data = new FormData($('#formChangePassword')[0]);
  data.append('userId', $('#userId').val());
  var url = baseURL + '/admin/profile/changePassword';

  $.ajax({
    url: url,
    type: "POST",
    data: data,
    dataType: "JSON",
    contentType: false,
    cache: false,
    processData: false,
    success: function(data) {
      switch(data.code) {
        case 201:
          $('.loaders-changePass').replaceWith('<i class="fa fa-floppy-o loaders-changePass">');
          $.confirm({
             title: 'Success!',
             content: data.response,
             type: 'green',
             typeAnimated: true,
             buttons: {
               btnSave: {
                 text: 'OK',
                 btnClass: 'btn-green',
                 action: function(event) {
                   $('#modal-default').modal('hide');
                   $('#formChangePassword')[0].reset();
                   $('.showHide').text('show').attr('data-showHide', '0');
                 }
              },
            }
          });
          break;
          case 400:
          $('.loaders').replaceWith('<i class="fa fa-floppy-o loaders">');
          $.confirm({
               title: 'Allowed Files size!',
               content: data.response,
               type: 'orange',
               typeAnimated: true,
               buttons: {
                 btnSave: {
                   text: 'OK',
                   btnClass: 'btn-orange',
                   action: function(event) {
                   }
                },
               }
            });
          break;
          case 405:
            return;
          break;
        default:
          $('.loaders-changePass').replaceWith('<i class="fa fa-floppy-o loaders-changePass">');
          $.confirm({
               title: 'Error!',
               content: data.response,
               type: 'red',
               typeAnimated: true,
               buttons: {
                 btnSave: {
                   text: 'OK',
                   btnClass: 'btn-red',
                   action: function(event) {
                   }
                },
                close: function(error) {

                }
               }
            });
        break;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });
  return false;
}

function updateData() {
  $('.loaders-update').replaceWith('<i class="fa fa-spinner fa-pulse fa-fw loaders-update"></i>');

  var fullName = $('input[name=full_name]').val();
  var email = $('input[name=email]').val(); 

  var valid = true;
  var elementInput = $('#formProfile').find('input');
  for (var i = 0; i < elementInput.length; i++) {
    var _el = elementInput[i].localName + '[name='+elementInput[i].name+']';
    var _elVal = elementInput[i].value;

    if (_elVal == '') {
      if (elementInput[i].name == 'full_name') {
        var parrentEl = elementInput[i].nextSibling.parentElement.parentElement;
        $(parrentEl).addClass('has-error');
        valid = false;
      }
      if (elementInput[i].name == 'email') {
        var parrentEl = elementInput[i].nextSibling.parentElement.parentElement;
        $(parrentEl).addClass('has-error');
        valid = false;
      }
    }

    if (_elVal !== '') {
      if (elementInput[i].name == 'full_name') {
        var parrentEl = elementInput[i].nextSibling.parentElement.parentElement;
        $(parrentEl).removeClass('has-error');
        valid = true;
      }
      if (elementInput[i].name == 'email') {
        var parrentEl = elementInput[i].nextSibling.parentElement.parentElement;
        $(parrentEl).removeClass('has-error');
        valid = true;
      }
    }
  }

  if (!valid) {
    $('.loaders-update').replaceWith('<i class="fa fa-floppy-o loaders-update">');
    return false;
  }

  if (!$('#agreement')[0].checked) {
    $('.loaders-update').replaceWith('<i class="fa fa-floppy-o loaders-update">');
    $('#agreement')[0].nextSibling.parentElement.style.color = '#f00';
    return false;
  }

  var data = new FormData($('#formProfile')[0]);
  data.append('userId', $('#userId').val());
  var url = baseURL + '/admin/profile/updateData';

  $.ajax({
    url: url,
    type: "POST",
    data: data,
    dataType: "JSON",
    contentType: false,
    cache: false,
    processData: false,
    success: function(data) {
      switch(data.code) {
        case 201:
          $('.loaders-update').replaceWith('<i class="fa fa-floppy-o loaders-update">');
          $.confirm({
             title: 'Success!',
             content: data.response,
             type: 'green',
             typeAnimated: true,
             buttons: {
               btnSave: {
                 text: 'OK',
                 btnClass: 'btn-green',
                 action: function(event) {
                    $('#agreement')[0].nextSibling.parentElement.style.color = '#000';
                    location.reload();
                 }
              },
            }
          });
          break;
          case 405:
            return;
          break;
        default:
          $('.loaders-update').replaceWith('<i class="fa fa-floppy-o loaders-update">');
          $.confirm({
               title: 'Error!',
               content: data.response,
               type: 'red',
               typeAnimated: true,
               buttons: {
                 btnSave: {
                   text: 'OK',
                   btnClass: 'btn-red',
                   action: function(event) {
                   }
                },
                close: function(error) {

                }
               }
            });
        break;
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
    }
  });

  return false;
}