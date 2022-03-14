
var URL = "http://site1.opencart";

var session = $.cookie('session');
if(session){
    SetSession(session);
    window.location.replace("/list.html");
}

$(document).ready(function () {


    $("#login").submit(function (event) {
        $("#error").hide();
        var formData = {
            login: $("#username").val(),
            password: $("#password").val(),
            remember: $("#remember").val(),
        };

        $.ajax({
            type: "POST",
            url: URL + "/auth",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            if(data.response){
                SetSession(data.response.token);
            }
            if($("#remember").val()){
                $.cookie('session', data.response.token, { expires: 1 });
            }
            window.location.replace("/list.html");
        }).fail(function (data) {
            console.log(data);
            $("#error").animate({
                height: 'toggle'
            });
        });

        event.preventDefault();
    });
});

function SetSession(token) {
    localStorage.setItem('session', token);
}
