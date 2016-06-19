var account = localStorage.account;
var passport = localStorage.passport;

console.log(localStorage.passport);

var questionId = $("#question_arg").text();
var mode = "";

$.ajax({
  dataType: "json",
  method: "GET",
  data:{
    "id": questionId,
  },
  url: "api/question.php",
  success: function(response) {
    var question = response.question;

    console.log(question);

    if(account == question.author) {
      console.log("edit mode");
      mode = "EDIT";
    }

    $("#question_title").text(question.content);

    $.ajax({
      dataType: "json",
      method: "GET",
      data:{
        "question": questionId,
        "account": account,
        "passport": passport
      },
      url: "api/answer.php",
      success: function(response) {
        var answers = response.answers.slice(0);



        while(answers.length > 0) {
          var index = Math.floor(Math.random()*answers.length);
          var answer = answers.splice(index, 1)[0];
          var newAnswerItem = $("<li class='answer_list_item selectable' answer='" + answer.id + "'>" + answer.content + "</li>");
          newAnswerItem.on("click", answerSelect);
          $("#answer_list").append(newAnswerItem);
        }
        answers = response.answers;

        $.ajax({
          dataType: "json",
          method: "GET",
          data:{
            "question": questionId,
            "account": account,
            "passport": passport
          },
          url: "api/attempt.php",
          success: function(response) {
            if(response.attempts.length > 0) {
              console.log("already attempted");
              $(".answer_list_item").unbind("click");
              $(".answer_list_item").removeClass("selectable");

              console.log(answers);
              var attemptedAnswer = $("[answer=" + response.attempts[0].answer + "]")
              attemptedAnswer.addClass("wrong");
              attemptedAnswer.attr("title", "Your answer");

              for(var i = 0; i < answers.length; i++) {
                if(answers[i].correct == 1) {
                  console.log(answers[i].id + " is correct");
                  var correctAnswer = $("[answer=" + answers[i].id + "]");
                  correctAnswer.addClass("correct");
                  correctAnswer.removeClass("wrong");
                  correctAnswer.attr("title", "Correct answer");
                }
              }

              //$("[answer=" + response.attempts[0].answer + "]").addClass("correct");

            } else {
              $("#body_wrap").append($("<div id='check_button' disabled>Check</div>"));
              $("#check_button").on("click", answerCheck);
            }

            if(mode.toUpperCase() == "EDIT") {
              $("#question_title").replaceWith("<input class='full' type='text' value='" + $("#question_title").text() + "'>");
            }
          }
        });
      }
    });

  }
});

var selection = -1;

var answerSelect = function(eventArg) {
  var answer = $(eventArg.currentTarget);

  if(answer.attr("disabled") == "disabled") {
    return;
  }

  if(answer.attr("selected") == "selected") {
      answer.removeAttr("selected");
      selection = -1;
      enableAllAnswers();
  } else {
    answer.attr("selected", "selected");
    selection = answer.attr("answer");
    disableAllAnswers(selection);
  }
}

var answerCheck = function(eventArg) {
  var selectedAnswer = $(".answer_list_item:not([disabled])");
  console.log(selectedAnswer);
  $.ajax({
    dataType: "json",
    method: "POST",
    data:{
      "account": 1,
      "key": passport,
      "answer": selectedAnswer.attr("answer")
    },
    url: "api/attempt.php",
    success: function(response) {
      console.log(response);
    }
  });
}


// EVENT BINDING



var disableAllAnswers = function(exceptAnswerId) {
  var answers = $(".answer_list_item");
  answers.attr("disabled", "");
  var answer = $(".answer_list_item[answer=" + exceptAnswerId + "]");
  answer.removeAttr("disabled");

  $("#check_button").removeAttr("disabled");

}

var enableAllAnswers = function() {
  var answers = $(".answer_list_item");
  answers.removeAttr("disabled");

  $("#check_button").attr("disabled", "");
}
