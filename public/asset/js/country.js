function addCountry() {
    var elem = document.getElementById('add_country_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');
    var name = $("#add_country_name").val();

    if (name !== '') {
        var countryLocalizations = [];
        for (index in tags) {
            if (tags[index].text !== undefined) {
                countryLocalizations.push({
                    Tag: tags[index].text,
                    TitleName: titleNames[index].value
                });
            }
        }

        var data = JSON.stringify({
            Name: name,
            CountryLocalizations: countryLocalizations
        });

        var command = 'AddCountry';
        var isSave = confirm("Хотите добавить новую страну?");
        if (isSave) {
            $.ajax({
                type: "GET",
                url: '/CountryAction',
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
    } else {
        alert('Заполните название страны');
    }
}

function findCountry(id) {
    $("#dropdownCountry .active").removeClass("active");
    $("#dropdownCountry #" + id).addClass("active");

    var data = JSON.stringify({Id: id});
    var command = 'FindCountry';

    $.ajax({
        type: "GET",
        url: '/CountryAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);

            var elem = document.getElementById('change_country_title_name');
            var titleNames = elem.getElementsByTagName('input');
            var tags = elem.getElementsByTagName('a');
            $("#change_country_name").val(response[0].Name);
            $("#country_id").val(response[0].CountryId);

            for (index in response) {
                for (i in tags) {
                    if (tags[i].text === response[index].Tag)  {
                        titleNames[i].value = response[index].TitleName;
                        tags[i].name = response[index].CountryLocalizationId;
                    }
                }
            }

        }
    });
}

function updateCountry() {

    var elem = document.getElementById('change_country_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');
    var name = $("#change_country_name").val();
    var id = $("#country_id").val();

    if (name !== '') {
        var isUpdate = confirm("Хотите редактировать страну?");
        if (isUpdate) {
            var countryLocalizations = [];
            for (index in tags) {
                if (tags[index].text !== undefined) {
                    countryLocalizations.push({
                        CountryLocalizationId:tags[index].name,
                       TitleName: titleNames[index].value,
                        Tag:tags[index].text
                    });
                }
            }


            var data = JSON.stringify({
                Id: id,
                Name: name,
                CountryLocalizations: countryLocalizations
            });

            var command = 'UpdateCountry';

            $.ajax({
                type: "GET",
                url: '/CountryAction',
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
    } else {
        alert('Заполните название страны');
    }
}