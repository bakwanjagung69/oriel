document.addEventListener('DOMContentLoaded', function(event) {
  /** UI Loaded Loading... */
  var loadedLoader__ = '<div id="loadedLoader__"></div>';
  $('#loadedLoader__').replaceWith(loadedLoader__);
  /** [END] - UI Loaded Loading... */
}, false);  

document.addEventListener("DOMContentLoaded", function(event) { 
  lazyLoadImg('lazy-load-img-avatar');

  $("#logout").on('click', function() {
      $.confirm({
       title: 'Logout?',
       type: 'dark',
        content: 'Your time is out, you will be automatically logged out in 10 seconds.',
        autoClose: 'logoutUser|10000',
        buttons: {
          btnclose: {
            text: 'Close',
            btnClass: 'btn-grey',
            action: function(event) {}
          },
          logoutUser: {
              btnClass: 'btn-dark',
              text: 'Logout',
              action: function () {
                  window.location = baseURL + "/admin/login/logout";
              }
          },
        }
    });
  });

});

function lazyLoadImg(_clasName) {
  return setTimeout(function() {
    $('.' + _clasName).lazy({
      bind: 'event',
      effect: 'fadeIn',
      visibleOnly: true,
      beforeLoad: function(element){
        // console.log('image is about to be loaded');
      },
      afterLoad: function(element) {
        // console.log('image was loaded successfully');
      },
      onError: function(element) {
        $(element[0].offsetParent.firstElementChild).attr('href', (baseURL + '/files/noimages'));
        $(element).attr('src', (baseURL + '/files/noimages'));
        var __msgAlert = ('=> Image could not be loaded!');
        throw __msgAlert;
      },
      onFinishedAll: function() {
        if(!this.config("autoDestroy")) {
          this.destroy();
        } 
        // console.log('finished loading elements');
        // console.log('lazy instance is about to be destroyed');
      }
    });
  }, 500);
}

function Pnotify(title = '', text = '', delay = 3000, bgColor = '#000') {
  return $.pnotify({
    title: title,
    text: text,
    delay: delay,
    animation: {
      effect_in: 'fade',
      effect_out: 'slide'
    },
    history: true,
    styling: 'bootstrap',
    before_open: function(PNotify){
      $(PNotify[0].firstChild).css({
        "border-radius": "6px"
      });
      PNotify.css({
        "top":"15px",
        "background-color": bgColor,
        "border-radius": "6px",
        "color": "#fff",
        "z-index": "99999"
      });
    }
  });
}

$(document).ready(function() {
  /* Popup Messages Opening Welcome Back **/
  var partsUri = document.referrer.split("/");
  var last_part_uri = partsUri[partsUri.length-1];
  
  if (last_part_uri == 'login') {
      if (localStorage.getItem('popupMsgOpening') == '0') {
       localStorage.setItem('popupMsgOpening', 0);
       Pnotify(
        'Info', 
        'Welcome Back <b>' + $('.user-menu').find('span').text() + '!</b>', 
        3000, 
        '#337ab7'
      );
      setTimeout(() => { 
        localStorage.setItem('popupMsgOpening', 1);
      }, 5000);
    }
  } else {
    localStorage.setItem('popupMsgOpening', 1);
  }

  /* [END] - Popup Messages Opening Welcome Back **/

  getJSONFiles();
 /** Navigation Menu Active or Not Active  */
  let currentURL = document.location.href;
  $(".nav-link").each(function(){    
    if ($(this).attr("href") === currentURL) {
        $('.nav-item').removeClass('active');
        $($(this)[0].parentElement).addClass('active');
        $($(this)[0].parentElement.parentElement.parentElement).addClass('active');
    } else {
      return;
    }  
  });
  /** END - Navigation Menu Active or Not Active  */
});

function ReadingLibExternalFile(url) {
  var splitLib = url.split("/").pop();
  var resLib   = splitLib.split(".").slice(-1)[0];

  var http = new XMLHttpRequest();
  http.open('HEAD', url, false);
  http.send();
  var result;

  try { 
    switch (http.status) {
      case 200:
        switch (resLib) {
          case 'js':
            $('head').append('<script type="text/javascript" src="'+http.responseURL+'"></script>');
          break;
          case 'css':
            $('head').append('<link rel="stylesheet" type="text/css" href="'+http.responseURL+'">');
          break;
          case 'ico':
            $('head').append('<link rel="icon" href="'+http.responseURL+'">');
          break;
        }
      break;
      case 404:
        result = false;
      break;
      case 500:
        result = false;
      break;
    }
  } catch(err) {
    Pnotify(
      'Error!', 
      'Can\'t Parse JS and CSS', 
      3000, 
      '#f00'
    );
  } finally {
    //code for finally block
  }


  return result;
}

function getJSONFiles() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', (baseURL + '/files/configLib?f=' + encodeURI(window.btoa('config~'+Math.floor(Date.now() / 1000)))));
  xhr.responseType = 'json';
  xhr.onload = function(e) {
    if (this.status == 200) {
      var currentURL = document.location.pathname;
      var splitURL   = currentURL.split('/');
      // console.log(splitURL);
      // console.log(window.location.pathname);
      var uriPath  = '';

      if (splitURL.includes('admin')) {
        /** CMS */
        try { 
          if (splitURL.length == 2) {
            uriPath = currentURL.split('/').slice(-1)[0];
            // console.log('CMS SET 0');
          }

          if (splitURL.length == 3) { /** List Data */
            uriPath = currentURL.split('/').slice(-1)[0];
            // console.log('CMS SET 1');
          }

          if (splitURL.length == 4) { /** Form without ID */
            uriPath = currentURL.split('/').slice(-2)[0] + '-' + currentURL.split('/').slice(-2)[1];
            // console.log('CMS SET 2');
          } 

          if (splitURL.length == 5) { /** Form with ID */
            uriPath = currentURL.split('/').slice(-3)[0] + '-' + currentURL.split('/').slice(-2)[0];
            // uriPath = currentURL.split('/').slice(-1)[0];
            // console.log('CMS SET 3');
          } 

        } catch(err) {
          throw new Error('URL error GET data config CMS');
        }
      } else {
        /** Front */
        try { 
          if (splitURL.length == 2) {
            uriPath = currentURL.split('/').slice(-1)[0];
            // console.log('FRONT SET 0');
          }

          if (splitURL.length == 3) { /** List Data */
            // uriPath = currentURL.split('/').slice(-1)[0];
            uriPath = currentURL.split('/').slice(-2)[0] + '-' + currentURL.split('/').slice(-2)[1];
            // console.log('FRONT SET 1');
          }

          if (splitURL.length == 4) { /** Form without ID */
            // uriPath = currentURL.split('/').slice(-2)[0] + '-' + currentURL.split('/').slice(-2)[1];
            uriPath = currentURL.split('/').slice(-3)[0] + '-' + currentURL.split('/').slice(-2)[0];
            // console.log('FRONT SET 2');
          } 

          if (splitURL.length == 5) { /** Form with ID */
            uriPath = currentURL.split('/').slice(-3)[0] + '-' + currentURL.split('/').slice(-2)[0];
            // console.log('FRONT SET 3');
          } 
        } catch(err) {
          throw new Error('URL error GET data config Front');
        } 
      }
      // console.log(uriPath);

      var resFileName = uriPath.replace(/[.*#+\?^${}()|[\]\\]/g, '');
      var validFileName = (resFileName == 'admin') ? 'dashboard' : resFileName;
      var _libs = this.response;

      if (splitURL.includes('admin')) {
        /** CMS */
        try { 
          var styleModules = _libs.cms.style_modules;
          for (var k = 0; k < styleModules.length; k++) {
            var splitLibCmsStyle = styleModules[k].path.split("/").pop();
            var resLibCmsStyle   = splitLibCmsStyle.split(".").slice(-2)[0];
            if (validFileName == resLibCmsStyle) {
              ReadingLibExternalFile(baseURL + styleModules[k].path);
            }
          }
        } catch(err) {
          throw new Error('Can\'t Read CSS Modules - [CMS]');
        }

        try { 
          var scriptModules = _libs.cms.script_modules;
          for (var s = 0; s < scriptModules.length; s++) {
            var splitLibCmsScript = scriptModules[s].path.split("/").pop();
            var resLibCmsScript   = splitLibCmsScript.split(".").slice(-2)[0];
            if (validFileName == resLibCmsScript) {
              ReadingLibExternalFile(baseURL + scriptModules[s].path);
            }
          }
        } catch(err) {
          throw new Error('Can\'t Read JS Modules - [CMS]');
        }

      } else {
        /** FRONT */
        try { 
          var styleModulesFront = _libs.frontend.style_modules;
          for (var i = 0; i < styleModulesFront.length; i++) {
            var splitLib = styleModulesFront[i].path.split("/").pop();
            var resLib   = splitLib.split(".").slice(-2)[0];

            if (splitURL.length == 4) {
              // if (validFileName.split("-").slice(-2)[0] == resLib) {
                ReadingLibExternalFile(baseURL + styleModulesFront[i].path);
              // }
            }
            if (validFileName == resLib) {
              ReadingLibExternalFile(baseURL + styleModulesFront[i].path);
            }
            if (validFileName == '') {
              if (styleModulesFront[i].path.split("/").slice(-1)[0] == 'home.css') {
                ReadingLibExternalFile(baseURL + styleModulesFront[i].path);
              }
            }
          }
        } catch(err) {
          throw new Error('Can\'t Read CSS Modules - [Front]');
        }

        try { 
          var scriptModulesFront = _libs.frontend.script_modules;
          for (var j = 0; j < scriptModulesFront.length; j++) {
            var splitLibFrontScript = scriptModulesFront[j].path.split("/").pop();
            var resLibFrontScript   = splitLibFrontScript.split(".").slice(-2)[0];

            if (splitURL.length == 4) {
              if (validFileName.split("-").slice(-2)[0] == resLibFrontScript) {
                ReadingLibExternalFile(baseURL + scriptModulesFront[j].path);
              }
            }
            if (validFileName == resLibFrontScript) {
              ReadingLibExternalFile(baseURL + scriptModulesFront[j].path);
            }
            if (validFileName == '') {
              if (scriptModulesFront[j].path.split("/").slice(-1)[0] == 'home.js') {
                ReadingLibExternalFile(baseURL + scriptModulesFront[j].path);
              }
            }
          }
        } catch(err) {
          throw new Error('Can\'t Read JS Modules - [Front]');
        }
      }
    }
  };
  return xhr.send();
}

function ReadingCSS(url) {
  try { 
    var splitLib = url.split("/").pop();
    var resLib   = splitLib.split(".").slice(-1)[0];

    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) { //4=this.DONE
        xhr.onreadystatechange = null;
        document.getElementById("demo").innerHTML = this.responseText;
        var obj  = this.responseText;
        var obj1 = JSON.parse(obj);
        console.log(obj);
       
        var style  = document.createElement('style');
        style.type = 'text/css';
        style.innerHTML = this.responseText;
        document.getElementsByTagName('head')[0].appendChild(style);

        var cssSheet = style.sheet; //this is the StyleSheet object you need
        var rule = cssSheet.cssRules[0]; //first rule defined in my.css
      }
    }
  } catch(err) {
    throw new Error('Can\'t Reading CSS!');
  }
  return xhr.send(); 
}