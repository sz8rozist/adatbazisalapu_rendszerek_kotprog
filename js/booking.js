$(document).ready(function () {
  const max_szemely = $(".seat_container").attr("id");
  console.log(max_szemely);
  var counter = 0;
  var values = [];

  $(".seat_container .seat_row .seat").click(function () {
    if ($(this).hasClass("kivalasztott")) {
      counter--;
      $(this).removeClass("kivalasztott");
      var index = values.indexOf($(this).attr("id"));
      if (index > -1) {
        values.splice(index, 1);
      }
    } else {
      counter++;
      if (counter <= max_szemely) {
        $(this).addClass("kivalasztott");
        values.push($(this).attr("id"));
      }
    }
    $("#ulohely_input").val(JSON.stringify(values));
    console.log(counter);
  });
});
