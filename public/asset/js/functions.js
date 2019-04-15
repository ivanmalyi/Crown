function send() {
    var login = $("#login").val();
    var password = $("#password").val();

    $.ajax({
        type: "GET",
        url: '/AdminPanel',
        data: '?login='+encodeURIComponent(login)+'&password='+encodeURIComponent(password),
        success: function (response) {
            document.write(response);
        }
    });
}

function addLocalization() {
    var name = $("#add_localization_name").val();
    var tag = $("#add_localization_tag").val();
    var command = 'AddLocalization';

    if (name !== '' && tag !== '') {
        var data = JSON.stringify({
            name: name,
            tag: tag
        });

        var isSave = confirm("Хотите добавить новый язык?");
        if (isSave) {
            $.ajax({
                type: "GET",
                url: '/LocalizationAction',
                data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
                success: function (response) {
                    if (parseInt(response) === 1) {
                        alert('Добавлено');
                    } else {
                        alert('Не удалось добавить');
                    }
                }
            });
        }
    } else {
        alert('Не все поля заполнены');
    }
}