$(document).ready(function() {
  
});

function lazyLoadImg(_clasName = '') {
  if (_clasName != '') {
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
          // console.log('image could not be loaded');
          console.log(element);
        },
        onFinishedAll: function() {
          if(!this.config("autoDestroy")) {
            this.destroy();
          } 
          // console.log('finished loading elements');
          // console.log('lazy instance is about to be destroyed');
        }
      });
    }, 800);
  }
}