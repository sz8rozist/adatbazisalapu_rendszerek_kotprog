$(".js-modal-trigger").click(function(){
  const modal = $(this).attr("data-target");
  $("#"+modal).addClass("is-active");
});

$(".modal-background, .modal-close, .modal-card-head .delete").click(function(){
  const modal = $(this).closest(".modal");
  var input = $(modal).find(".input");
  $(input).val("");
 $(modal).removeClass("is-active");
});

$(document).keydown(function(){
  const e = event || window.event;

  if (e.keyCode === 27) {
    // Escape key
    $(".modal").removeClass("is-active");
  }
});

