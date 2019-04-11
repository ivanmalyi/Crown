function send() {
    var login = $("#login");
    var password = $("#password");

    $.ajax({
        type: "POST",
        url: '/AdminPanel/auth',
        data: savePaymentData,
        success: function (response) {
            alert(response);
        }
    });
}