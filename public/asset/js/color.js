function addColor() {
    var elem = document.getElementById('add_color_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');
    var name = $("#add_color_name").val();

    if (name !== '') {
        var colorLocalizations = [];
        for (index in tags) {
            if (tags[index].text !== undefined) {
                colorLocalizations.push({
                    Name: name,
                    Tag: tags[index].text,
                    ColorTitleName: titleNames[index].value
                });
            }
        }
        var data = JSON.stringify(colorLocalizations);
        var command = 'AddColor';
        var isSave = confirm("Хотите добавить новый цвет?");

        if (isSave) {
            $.ajax({
                type: "GET",
                url: '/ColorAction',
                data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
                success: function (response) {
                    if (parseInt(response) === 1) {
                        alert('Добавлено');
                        location.reload(true);
                    } else {
                        alert('Не удалось добавить');
                    }
                }
            });
        }
    }
}

function findColor(id) {
    $("#dropdownColor .active").removeClass("active");
    $("#dropdownColor #" + id).addClass("active");

    var data = [];
    data.push({ColorId: id});
    data = JSON.stringify(data);
    var command = 'FindColor';

    $.ajax({
        type: "GET",
        url: '/ColorAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);

            var elem = document.getElementById('change_color_title_name');
            var titleNames = elem.getElementsByTagName('input');
            var tags = elem.getElementsByTagName('a');
            $("#change_color_name").val(response[0].Name);
            $("#color_id").val(response[0].ColorId);

            for (index in response) {
                for (i in tags) {
                    if (tags[i].text === response[index].Tag)  {
                        titleNames[i].value = response[index].ColorTitleName;
                        tags[i].name = response[index].ColorLocalizationId;
                    }
                }
            }

        }
    });
}

function updateColor() {

    var elem = document.getElementById('change_color_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');
    var name = $("#change_color_name").val();
    var id = $("#color_id").val();

    if (name !== '') {
        var isUpdate = confirm("Хотите редактировать цвет?");
        if (isUpdate) {
            var colorLocalizations = [];
            for (index in tags) {
                if (tags[index].text !== undefined) {
                    colorLocalizations.push({
                        ColorId: id,
                        Name: name,
                        ColorLocalizationId:tags[index].name,
                        TitleName: titleNames[index].value,
                        Tag:tags[index].text
                    });
                }
            }

            var data = JSON.stringify(colorLocalizations);
            var command = 'UpdateColor';

            $.ajax({
                type: "GET",
                url: '/ColorAction',
                data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
                success: function (response) {
                    if (parseInt(response) === 1) {
                        alert('Обновлено');
                        location.reload(true);
                    } else {
                        alert('Не удалось обновить');
                    }
                }
            });
        }
    }
}