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

function displayQuestion(question) {
  $("#title").text(question.title);
  $("#answers").empty();

  get("/api/answers", {question: question.id}, function(res) {
    var answers = JSON.parse(res).answers;

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
}


var questions = [];

get("/api/questions", {course: 1}, function(res) {
  questions = JSON.parse(res).questions;
  console.log(questions);
  displayQuestion(questions[0]);
});


$("#title").text("Who invented the Turing machine?");

printAnswer({id: 1, content: "Alan Turing"});
printAnswer({id: 2, content: "Donald Knuth"});
printAnswer({id: 3, content: "Ada Lovelace"});
printAnswer({id: 4, content: "Bill Gates"});
