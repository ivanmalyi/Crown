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
    $("#dropdownCountryForCity .active").removeClass("active");
    $("#dropdownCity .active").removeClass("active");
    $("#dropdownCountryForCity #" + id).addClass("active");

    var data = JSON.stringify({Id: id});
    var command = 'FindCity';

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
            $("#country_id").val(response[0].Id);

            for (index in response) {
                for (i in tags) {
                    if (tags[i].text === response[index].Tag)  {
                        titleNames[i].value = response[index].TitleName;
                        tags[i].name = response[index].Id;
                    }
                }
            }

        }
    });
}