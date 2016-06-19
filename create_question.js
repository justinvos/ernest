var createClick = function(event) {
  console.log("click");
  $.ajax({
    dataType: "json",
    method: "POST",
    data:{
      "course": 2,
      "content": $("#content").val(),
      "account": localStorage.account,
      "passport": localStorage.passport
    },
    url: "api/question.php"
  });
}

$("#button").on("click", createClick);
