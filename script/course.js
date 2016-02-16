var joinClick = function(account, token, course)
{
  console.log('join click');

  $.ajax({
    data : {'account' : account, 'token' : token, 'course' : course, 'moderator' : 0},
    type: 'POST',
    url: 'api/memberships.php',
    success: function()
    {
      location.reload();
    }
  });


};
