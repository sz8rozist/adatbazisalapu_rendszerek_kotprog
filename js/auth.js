$(document).ready(function () {
  $("#login_btn").click(function () {
    let username = $("[name=username]");
    let password = $("[name=password]");
    if ($(username).val() == "") {
      $(username).addClass("is-danger");
    } else {
      $(username).removeClass("is-danger");
    }
    if ($(password).val() == "") {
      $(password).addClass("is-danger");
    } else {
      $(password).removeClass("is-danger");
    }
    if ($(username).val() != "" && $(password).val() != "") {
      $.post(
        "login.php",
        { username: $(username).val(), password: $(password).val() },
        function (result) {
          var res = JSON.parse(result);
          if (res.succes) {
            window.location = res.location;
          } else {
            $(username).addClass("is-danger");
            $(password).addClass("is-danger");
            $(".error").html("Sikertelen bejelentkezés!");
          }
        }
      );
    }
  });

  $("#signup_btn").click(function () {
    console.log("CLICK");
    let username = $("#signup_username");
    let password = $("#signup_password");
    let modal = $(this).parent().closest(".modal");
    if ($(username).val() == "") {
      $(username).addClass("is-danger");
    } else {
      $(username).removeClass("is-danger");
    }
    if ($(password).val() == "") {
      $(password).addClass("is-danger");
    } else {
      $(password).removeClass("is-danger");
    }
    if ($(username).val() != "" && $(password).val() != "") {
      $.post(
        "signup.php",
        { username: $(username).val(), password: $(password).val() },
        function (result) {
          var response = JSON.parse(result);
          if (response.status) {
            $(modal).removeClass("is-active");
            var input = $(modal).find(".input");
            $(input).val("");
            $(modal).find("has-text-danger").html("");
          } else {
            console.log(response.msg);
            $(username).addClass("is-danger");
            $(".signup_error").html(response.msg);
          }
        }
      );
    }
  });
});
