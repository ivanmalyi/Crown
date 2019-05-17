function selectCountryForAddCity(id) {
    $("#dropdownCountryAddForCity .active").removeClass("active");
    $("#dropdownCountryAddForCity #" + id).addClass("active");
}

function addCity() {
    var elem = document.getElementById('add_city_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');
    var city = $("#add_city_name").val();
    var country = $("#dropdownCountryAddForCity .active");

    var isAdd = confirm("Хотите добавить город?");

    if (isAdd) {
        if (city !== '' && country.hasClass("active")) {
            var data = [];
            for (index in tags) {
                if (tags[index].text !== undefined) {
                    data.push({
                        CountryId: country.attr('id'),
                        CityName: city,
                        CityTitleName: titleNames[index].value,
                        Tag: tags[index].text

                    });
                }
            }
            data = JSON.stringify(data);
            var command = 'AddCity';

            $.ajax({
                type: "GET",
                url: '/CityAction',
                data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
                success: function (response) {
                    if (parseInt(response) === 1) {
                        alert('Добавлено');
                    } else {
                        alert('Не удалось добавить');
                    }
                }
            });
        } else {
            alert("Не выбрана страна или не введено название города");
        }
    }
}

function findCitiesForCountry(id) {
    $('#dropdownCity').empty();
    $("#dropdownCountryForCity .active").removeClass("active");
    $("#dropdownCountryForCity #" + id).addClass("active");

    var data = [];
    data.push({CountryId: id});
    data = JSON.stringify(data);
    var command = 'FindCitiesForCountry';

    $.ajax({
        type: "GET",
        url: '/CityAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);
            var htmlCities = '';
            for (index in response) {
                htmlCities += '<a id="'+response[index].Id+'" onclick="findCity(this.id)" class="dropdown-item" href="#">'+response[index].Name+'</a>'
            }
            $(htmlCities).appendTo('#dropdownCity');
        }
    });
}

function findCity(id) {
    $("#dropdownCity .active").removeClass("active");
    $("#dropdownCity #" + id).addClass("active");

    var data = [];
    data.push({CityId: id});
    data = JSON.stringify(data);
    var command = 'FindCity';

    $.ajax({
        type: "GET",
        url: '/CityAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);

            var elem = document.getElementById('change_city_title_name');
            var titleNames = elem.getElementsByTagName('input');
            var tags = elem.getElementsByTagName('a');
            $("#change_city_name").val(response[0].Name);
            $("#city_id").val(response[0].CityId);

            for (index in response) {
                for (i in tags) {
                    if (tags[i].text === response[index].Tag) {
                        titleNames[i].value = response[index].TitleName;
                        tags[i].name = response[index].LocalizationId;
                    }
                }
            }
        }
    });
}

function updateCity() {

    var elem = document.getElementById('change_city_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');
    var name = $("#change_city_name").val();
    var id = $("#city_id").val();
    var country = $("#dropdownCountryAddForCity .active");

    if (name !== '') {
        var isUpdate = confirm("Хотите редактировать город?");
        if (isUpdate) {
            var cityLocalizations = [];
            for (index in tags) {
                if (tags[index].text !== undefined) {
                    cityLocalizations.push({
                        CountryId: country.attr('id'),
                        CityId:id,
                        CityName:name,
                        CityTitleNameId:tags[index].name,
                        CityTitleName: titleNames[index].value,
                        Tag:tags[index].text
                    });
                }
            }

            var data = JSON.stringify(cityLocalizations);
            var command = 'UpdateCity';

            $.ajax({
                type: "GET",
                url: '/CityAction',
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
        alert('Заполните название города');
    }
}