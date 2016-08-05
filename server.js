var express = require('express');
var app = express();
var path = require('path');
var bodyParser = require('body-parser');
var model = require("./model.js");


app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: true}));

app.use(express.static(__dirname + "/views"));

app.get("/", function (req, res) {
  res.sendFile(path.join(__dirname + "/views/index.html"));
});

app.get("/api/questions", function(req, res) {

  if(req.query.course != null) {
    model.selectQuestionsByCourse(req.query.course, function(questions) {
      var selectedQuestions = [];

      var n = 10;

      for(var i = 0; i < n; i++) {
        selectedQuestions.push(questions[Math.floor(questions.length * Math.random())]);
      }

      res.set("Content-Type", "application/json");
      res.send(JSON.stringify({questions: selectedQuestions}));
    });
  }
});


app.get("/api/answers", function(req, res) {
  if(req.query.question != null) {
    model.selectAnswersByQuestion(req.query.question, function(answers) {
      res.set("Content-Type", "application/json");
      res.send(JSON.stringify({answers: answers}));
    });
  }
});

app.listen(3000, function () {
  console.log("Example app listening on port 3000!");
});
