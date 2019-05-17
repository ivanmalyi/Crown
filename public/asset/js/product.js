function findCitiesForProduct(id) {
    $('#dropdownCityForProduct').empty();
    $("#dropdownCountryForProduct .active").removeClass("active");
    $("#dropdownCountryForProduct #" + id).addClass("active");

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
                htmlCities += '<a id="'+response[index].Id+'" onclick="selectCityForProduct(this.id)" class="dropdown-item" href="#">'+response[index].Name+'</a>'
            }
            $(htmlCities).appendTo('#dropdownCityForProduct');
        }
    });

    $("body").scrollTop(1000);
}

function selectCityForProduct(id) {
    $("#dropdownCityForProduct .active").removeClass("active");
    $("#dropdownCityForProduct #" + id).addClass("active");

    $("body").scrollTop(60);
}