var navToQuestion = function(event) {
  var questionId = $(event.target).attr("question");
  window.location = "question.php?id=" + questionId;
}

var printQuestions = function(filter) {
  $.ajax({
    dataType: "json",
    method: "GET",
    data:{
      "account": 1,
      "course": 1,
      "filter": filter,
      "key": "d9bf30188ef6467d83cff3ae00f81f34"
    },
    url: "api/question.php",
    success: function(response) {
      var questions = response.questions;
      var questionList = $("#question_list");
      questionList.empty();

      for(var i = 0; i < questions.length; i++) {
        var newQuestionItem = $("<div class='question_list_item' question='" + questions[i].id + "'>" + questions[i].content + "</div>");
        questionList.append(newQuestionItem);
      }
      $(".question_list_item").on("click", navToQuestion);
    }
  });
}

var printUnansweredQuestions = function() {
  printQuestions("UNANSWERED");
  $("#page_heading").text("Unanswered questions");
}

var printAnsweredQuestions = function() {
  printQuestions("ANSWERED");
  $("#page_heading").text("Answered questions");
}

var printAuthoredQuestions = function() {
  printQuestions("AUTHORED");
  $("#page_heading").text("Your questions");
}


$("#unanswered_link").on("click", printUnansweredQuestions);
$("#answered_link").on("click", printAnsweredQuestions);
$("#owned_link").on("click", printAuthoredQuestions);
