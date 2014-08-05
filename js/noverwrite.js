cj(function($) {
  $.each(["#first_name","#middle_name","#last_name"],function (k,v) {
    if ($(v).val() != "") {
      $(v).attr("readonly", true).css("border", 0).css("background-color", "inherit");
    }
  });
});
