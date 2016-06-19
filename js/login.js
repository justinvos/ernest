
var loginClick = function() {
  localStorage.account = 1;
  localStorage.passport = "d9bf30188ef6467d83cff3ae00f81f34";

  window.location = "dash.php";
}


$("#login_button").on("click", loginClick);
