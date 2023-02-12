$(document).ready(function(){
    $("#login_btn").click(function(){
        let username = $("[name=username]");
        let password = $("[name=password]");
        console.log(username, password);
        if($(username).val() == ""){
            $(username).addClass("is-danger");
        }else{
            $(username).removeClass("is-danger");
        }
        if($(password).val() == ""){
            $(password).addClass("is-danger");
        }else{
            $(password).removeClass("is-danger");
        }
        if($(username).val() != "" && $(password).val() != ""){
            $.post("login.php",{username: $(username).val(), password: $(password).val()}, function(result){
                var res = JSON.parse(result);
                console.log(res);
                if(res.succes){
                    window.location = res.location;
                }else{
                    $(username).addClass("is-danger");
                    $(password).addClass("is-danger");
                    $(".error").html("Sikertelen bejelentkezés!");
                }
            });
        }
    });
});