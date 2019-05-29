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
                htmlCities += '<a id="'+response[index].Id+'" onclick="selectCityForProduct(this.id)" class="dropdown-item" style="cursor: pointer">'+response[index].Name+'</a>'
            }
            $(htmlCities).appendTo('#dropdownCityForProduct');
        }
    });
}

function selectCityForProduct(id) {
    $("#dropdownCityForProduct .active").removeClass("active");
    $("#dropdownCityForProduct #" + id).addClass("active");
}

function addProduct() {
    var elem = document.getElementById('add_product_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');

    var elem2 = document.getElementById('add_product_description');
    var descriptions = elem2.getElementsByTagName('textarea');

    var name = $("#add_product_name").val();
    var status = document.getElementById("status").checked;
    var vip = document.getElementById("vip").checked;
    var height = $("#add_height").val();
    var year = $("#add_year").val();
    var color = document.getElementById("select_color").value;
    var country = $("#dropdownCountryForProduct .active").attr('id');
    var city = $("#dropdownCityForProduct .active").attr('id');

    if (name !== '') {
        var productLocalizations = [];
        for (index in tags) {
            if (tags[index].text !== undefined) {
                productLocalizations.push({
                    ProductName: name,
                    Status: status,
                    VIP: vip,
                    Height: height,
                    Year: year,
                    ColorId: color,
                    CountryId: country,
                    CityId: city,
                    Tag: tags[index].text,
                    ProductTitleName: titleNames[index].value,
                    Description: descriptions[index].value
                });
            }
        }

        var data = JSON.stringify(productLocalizations);
        var command = 'AddProduct';
        var isSave = confirm("Хотите добавить новый продукт?");

        if (isSave) {
            $.ajax({
                type: "GET",
                url: '/ProductAction',
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
    }
}

function findProduct() {
    var productId = document.getElementById("select_product").value;

    var data = [];
    data.push({ColorId: id});
    data = JSON.stringify(data);
    var command = 'FindProduct';

    $.ajax({
        type: "GET",
        url: '/ProductAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);
        }
    });
}

