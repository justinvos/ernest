var answer = null;

var answerClick = function(answer_id)
{
  var selected_answer_element = document.getElementById('answer_' + answer_id);
  var answer_elements = document.getElementsByClassName('answer');

  if(answer == null)
  {
    answer = answer_id;



    for(i = 0; i < answer_elements.length; i++)
    {
      answer_elements[i].className = "answer box notselected";
    }

    selected_answer_element.className = "answer box selected";
    selected_answer_element.disabled = false;
    console.log(answer_id);
  }
  else if(answer == answer_id)
  {
    answer = null;

    for(i = 0; i < answer_elements.length; i++)
    {
      answer_elements[i].className = "answer box";
    }
  }

}


var submitClick = function(account, token)
{

  $.ajax({
    data : {'account' : account, 'token' : token, 'answer' : answer},
    type: 'POST',
    url: 'api/votes.php'
  });
};