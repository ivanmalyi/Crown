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
            Name: name,
            Tag: tag
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

function findLocalization(id) {
    $("#dropdownLocalization .active").removeClass("active");
    $("#dropdownLocalization #" + id).addClass("active");

    var data = JSON.stringify({Id: id});
    var command = 'FindLocalization';

    $.ajax({
        type: "GET",
        url: '/LocalizationAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);
            $("#change_localization_name").val(response.Name);
            $("#change_localization_tag").val(response.Tag);
            $("#change-locale").val(response.Id);
        }
    });
}

function updateLocalization(id) {
    var name = $("#change_localization_name").val();
    var tag = $("#change_localization_tag").val();

    var data = JSON.stringify({
        Id: id,
        Name: name
    });
    var command = 'UpdateLocalization';

    var isUpdate = confirm("Хотите редактировать язык?");

    if (isUpdate) {
        $.ajax({
            type: "GET",
            url: '/LocalizationAction',
            data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
            success: function (response) {
                if (parseInt(response) === 1) {
                    alert('Изменено');
                } else {
                    alert('Не удалось изменить');
                }
            }
        });
    }
}