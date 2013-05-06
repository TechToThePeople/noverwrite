cj(function($) {
  if ($("#first_name").val() != "") {
    $("#first_name").attr("readonly", true).css("border", 0).css("background-color", "inherit");
  }

  if ($("#last_name").val() != "") {
    $("#last_name").attr("readonly", true).css("border", 0).css("background-color", "inherit");
  }
});
