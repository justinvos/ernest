var courseId = $("#course_arg").text();

var questions = [];
var stage = 0;

var numberOfQuestions = 10;
var numberCorrect = 0;

var wrongQuestions = [];

var getQuestionFromId = function(id) {
  for(var i = 0; i < questions.length; i++) {
    if(questions[i].id == id) {
      return questions[i];
    }
  }
}

var getAnswerFromId = function(id) {
  for(var i = 0; i < questions[stage].answers.length; i++) {
    if(questions[stage].answers[i].id == id) {
      return questions[stage].answers[i];
    }
  }
}

var answerClick = function(event) {
  $(event.target).addClass("wrong");
  var selectedAnswer = $(event.target).attr("answer");
  var answers = $(".answer");
  var correct = false;

  for(var i = 0; i < answers.length; i++) {
    var answerElement = $(answers[i]);
    var answerId = answerElement.attr("answer");
    if(getAnswerFromId(answerId).correct == "1") {

      $(answers[i]).addClass("correct");

      if(answerId == selectedAnswer) {
        $(answers[i]).removeClass("wrong");
        numberCorrect++;
        correct = true;
      }
    }
  }

  if(!correct) {
    wrongQuestions.push(questions[stage].content);
  }

  setTimeout(function() {
    stage++;
    if(stage < numberOfQuestions) {
      displayQuestion();
    } else {
      finished();
    }

  }, 3000);
}

var displayQuestion = function() {
  $("#question_title").text(questions[stage].content);

  var questionList = $("#question_list");
  questionList.empty();

  console.log(questions[stage]);

  var answers = questions[stage].answers.slice(0);

  while(answers.length > 0) {
    var r = Math.floor(Math.random() * answers.length);
    var newAnswerItem = answers.splice(r, 1)[0];
    var newAnswerElement = $("<li answer='" + newAnswerItem.id + "'>" + newAnswerItem.content + "</li>");
    newAnswerElement.on("click", answerClick);
    newAnswerElement.addClass("answer");
    questionList.append(newAnswerElement);
  }
}

var finished = function() {
  $("#question_title").text("Score: " + numberCorrect + " / " + numberOfQuestions);

  var questionList = $("#question_list");
  questionList.empty();

  var wrongQuestionsList = $("<ul id='wrongQuestions_list'></ul>");

  $("#body_wrap").append("<p id='wrongQuestions_title'>Questions you got wrong:</p>");
  $("#body_wrap").append(wrongQuestionsList);

  for(var i = 0; i < wrongQuestions.length; i++) {
    wrongQuestionsList.append("<li>" + wrongQuestions[i] + "</li>");
  }
  console.log("DONE");
}

$.ajax({
  dataType: "json",
  method: "GET",
  data:{
    "course": courseId,
  },
  url: "api/question.php",
  success: function(response) {

    var questionsLoaded = 0;

    for(var i = 0; i < numberOfQuestions; i++) {
      var r = Math.floor((Math.random() * response.questions.length));
      var newQuestionItem = response.questions[r];
      questions.push(newQuestionItem);

      $.ajax({
        dataType: "json",
        method: "GET",
        data:{
          "question": newQuestionItem.id,
          "account": localStorage.account,
          "passport": localStorage.passport
        },
        url: "api/answer.php",
        success: function(response) {
          var question = getQuestionFromId(response.answers[0].question);

          question.answers = response.answers.splice(0);

          questionsLoaded++;
          console.log(questionsLoaded);

          if(questionsLoaded == numberOfQuestions) {
            displayQuestion();
          }
        }
      });
    }
    console.log(questions);

  }
});
