function send() {
    var login = $("#login").val();
    var password = $("#password").val();

    $.ajax({
        type: "GET",
        url: '/A/B/AdminPanel',
        data: '?login='+encodeURIComponent(login)+'&password='+encodeURIComponent(password),
        success: function (response) {
            document.write(response);
        }
    });
}

function exit() {
    $.ajax({
        type: "GET",
        url: '/AdminPanel/exit',
        success: function (response) {
            document.write(response);
            location.reload(true);
        }
    });
}