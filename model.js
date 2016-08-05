var fs = require("fs");
var mysql = require('mysql');


var connectionDetails = JSON.parse(fs.readFileSync("db.json"));
var connection = mysql.createConnection(connectionDetails);

function selectQuestionsByCourse(course, callback) {
  connection.query("SELECT id, title, course FROM questions WHERE course=?;", [course], function(err, rows, fields) {
    if (err) {
      console.log(err);
    } else {
      callback(JSON.parse(JSON.stringify(rows)));
    }
  });
}

function selectAnswersByQuestion(question, callback) {
  connection.query("SELECT id, content, question, correct FROM answers WHERE question=?;", [question], function(err, rows, fields) {
    if (err) {
      console.log(err);
    } else {
      callback(JSON.parse(JSON.stringify(rows)));
    }
  });
}


exports.selectQuestionsByCourse = selectQuestionsByCourse;
exports.selectAnswersByQuestion = selectAnswersByQuestion;
