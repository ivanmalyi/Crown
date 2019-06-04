function loadMainPage() {
    var language = window.navigator.language;

    if (language !== undefined && language !== false) {
        language = language.substr(0, 2).toLowerCase();
    } else {
        language = 'ru';
    }

    $.ajax({
        type: "GET",
        url: '/',
        data: '?language=' + encodeURIComponent(language),
        success: function (response) {
            document.write(response);
        }
    });
}

function loadPageForSelectedLanguage() {
    var languageTag = document.getElementById("select_language").value;

    $.ajax({
        type: "GET",
        url: '/',
        data: '?selectedLanguage=' + encodeURIComponent(languageTag),
        success: function (response) {
            $('body').empty();
            document.write(response);
        }
    });
}

function findCityForMenu(id) {

    var data = [];
    data.push({CountryId: id});
    data = JSON.stringify(data);
    var command = 'FindCitiesForCountryWithLocalization';

    $.ajax({
        type: "GET",
        url: '/MainPageCityAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);
            var htmlCities = '';
            for (index in response) {
                htmlCities += '<a id="'+response[index].Id+'" onclick="findCity(this.id)" class="dropdown-item" href="#">'+response[index].Name+'</a>'
            }
            $('#select_city').empty();
            $(htmlCities).appendTo('#select_city');
        }
    });
}