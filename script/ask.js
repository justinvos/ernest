
var anotherAnswerClick = function()
{
  var answerBox = document.createElement("input");

  answerBox.className = 'answer_box';
  answerBox.type = 'text';
  answerBox.placeholder = 'Answer';

  answerBox.name = 'answer_' + document.getElementsByClassName('answer_box').length;

  document.getElementById('answer_box_wrap').appendChild(answerBox);
}

var askClick = function(account, token, course)
{
  $.ajax({
    data : {'account' : account, 'token' : token, 'course' : course, 'question' : document.getElementById('question_box').value},
    type: 'POST',
    url: 'api/question.php',
    success: function(data){
      var question_id = JSON.parse(data)['question'];

      var answers = [];

      var answerBoxes = document.getElementsByClassName('answer_box');

      for(i = 0; i < answerBoxes.length; i++)
      {
        if(answerBoxes[i].value != '')
        {
          answers.push(answerBoxes[i].value);
        }
      }

      $.ajax({
        data : {'account' : account, 'token' : token, 'question_id' : question_id, 'answers' : answers.join(String.fromCharCode(31))},
        type: 'POST',
        url: 'api/answer.php'
      });
    }
  });
};
