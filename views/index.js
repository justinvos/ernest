function get(url, data, success) {
  $.ajax({
    data: data,
    type: "GET",
    url: url,
    success: success
  });
}

function post(url, data, success) {
  $.ajax({
    contentType: "application/x-www-form-urlencoded",
    data: data,
    type: "POST",
    url: url,
    success: success
  });
}

function findById(items, id) {
  for(var i = 0; i < items.length; i++) {
    if(items[i].id == id) {
      return i;
    }
  }
  return null;
}

function shuffle(items) {
  var unshuffled = items.slice();
  var shuffled = [];
  while(unshuffled.length > 0) {
    var i = Math.floor(unshuffled.length * Math.random());
    shuffled.push(unshuffled.splice(i, 1)[0]);
  }
  return shuffled;
}

function displayQuestion(question) {
  $("#title").text(question.title);
  $("#answers").empty();

  get("/api/answers", {question: question.id}, function(res) {
    var answers = shuffle(res.answers);

    for(var i = 0; i < answers.length; i++) {
      printAnswer(answers[i]);
    }
  });
}

function printAnswer(answer) {
  var answerItem = $("<li answer='" + answer.id + "' class='answer'>" + answer.content + "</li>");
  answerItem.click(onAnswerClick);
  $("#answers").append(answerItem);
}

function onAnswerClick(event) {
  $(event.target).toggleClass("selected");

  get("/api/answers", {question: question.id}, function(res) {
    var answers = res.answers;

    var answerItems = $("#answers").children();

    for(var i = 0; i < answerItems.length; i++) {
      var answerItem = $(answerItems[i]);

      if(answerItem.hasClass("selected")) {
        var f = findById(answers, answerItem.attr("answer"));
        var answer = answers[f];
        if(answer.correct == 1) {
          answerItem.addClass("correct");
          correct++;
          setTimeout(function() {
            question = questions.splice(0, 1)[0];
            displayQuestion(question);
          }, 3000);
        } else {
          answerItem.addClass("incorrect");
          incorrect++;
        }
      }
    }
  });
}


var questions = [];
var question;


var correct = 0;
var incorrect = 0;

get("/api/questions", {course: 1}, function(res) {
  questions = res.questions;
  question = questions.splice(0, 1)[0];
  displayQuestion(question);
});
