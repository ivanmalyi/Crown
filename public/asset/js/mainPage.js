function findLocalization() {
    var language = window.navigator.language;

    if (language !== undefined && language !== false) {
        language = language.substr(0, 2).toLowerCase();
    } else {
        language = 'ru';
    }

    return language;
}

function loadMainPage() {
    var language = findLocalization();
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

    var language = findLocalization();

    var data = [];
    data.push({CountryId: id});
    data = JSON.stringify(data);

    var command = 'FindCitiesForCountryWithLocalization';
    $.ajax({
        type: "GET",
        url: '/MainPageCityAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data) + '&language='+encodeURIComponent(language),
        success: function (response) {
            if (response !== '[]') {
                response = jQuery.parseJSON(response);
                var htmlCities = '';
                for (index in response) {
                    htmlCities += '<option value="' + response[index].CityId + '">' + response[index].TitleName + '</option>';
                }
                $('#select_city').empty();
                $(htmlCities).appendTo('#select_city');
            }
        }
    });
}

function findProductByFilter() {
    var yearFrom = $("#year-from").val();
    var yearTo = $("#year-to").val();
    var heightFrom = $("#height-from").val();
    var heightTo = $("#height-to").val();
    var colorId = document.getElementById("select_color").value;
    var countryId = document.getElementById("select_country").value;
    var cityId = document.getElementById("select_city").value;

    var language = findLocalization();


    var data = {
        YearFrom: yearFrom,
        YearTo: yearTo,
        HeightFrom: heightFrom,
        HeightTo: heightTo,
        ColorId: colorId,
        CountryId: countryId,
        CityId: cityId

    };
    data = JSON.stringify(data);

    $.ajax({
        type: "GET",
        url: '/',
        data: '?data=' + encodeURIComponent(data) + '&language='+encodeURIComponent(language),
        success: function (response) {
            $('body').empty();
            document.write(response);
        }
    });
}