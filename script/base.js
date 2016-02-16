
var logoutClick = function(account, token)
{
  $.ajax({
    data : {'account' : account, 'token' : token},
    type: 'DELETE',
    url: 'api/session.php'
  });
}
