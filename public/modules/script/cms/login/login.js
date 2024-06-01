$( document ).ready(function() {
  localStorage.setItem('popupMsgOpening', 0);

  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye-slash");
    var password = $("input[name=password]");
    if (password.attr("type") == "password") {
      password.attr("type", "text");
    } else {
      password.attr("type", "password");
    }
  });
  document.body.style.overflow = 'hidden';
});