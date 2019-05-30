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
                htmlCities += '<a id="'+response[index].Id+'" onclick="findCityForProduct(this.id)" class="dropdown-item" style="cursor: pointer">'+response[index].Name+'</a>'
            }
            $(htmlCities).appendTo('#dropdownCityForProduct');
        }
    });
}

function findCityForProduct(id) {
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

function updateProduct() {
    var elem = document.getElementById('change_product_title_name');
    var titleNames = elem.getElementsByTagName('input');
    var tags = elem.getElementsByTagName('a');

    var elem2 = document.getElementById('change_product_description');
    var descriptions = elem2.getElementsByTagName('textarea');

    var name = $("#change_product_name").val();
    var productId = $("#product_id").val();
    var status = document.getElementById("status_change").checked;
    var vip = document.getElementById("vip_change").checked;
    var height = $("#change_height").val();
    var year = $("#change_year").val();
    var color = document.getElementById("select_color_change").value;
    var country = $("#dropdownCountryForProductChange .active").attr('id');
    var city = $("#dropdownCityForProductChange .active").attr('id');

    if (name !== '') {
        var isUpdate = confirm("Хотите редактировать продукт?");
        if (isUpdate) {
            var productLocalizations = [];
            for (index in tags) {
                if (tags[index].text !== undefined) {
                    productLocalizations.push({
                        ProductId: productId,
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
                        ProductLocalizationId:tags[index].name,
                        Description: descriptions[index].value
                    });
                }
            }

            var data = JSON.stringify(productLocalizations);
            var command = 'UpdateProduct';

            $.ajax({
                type: "GET",
                url: '/ProductAction',
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

function findProduct() {
    var productId = document.getElementById("select_product").value;

    var data = [];
    data.push({ProductId: productId});
    data = JSON.stringify(data);
    var command = 'FindProduct';

    $.ajax({
        type: "GET",
        url: '/ProductAction',
        data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
        success: function (response) {
            response = jQuery.parseJSON(response);

            $("#change_product_name").val(response[0].ProductName);
            $("#product_id").val(response[0].ProductId);
            document.getElementById("status_change").checked = parseInt(response[0].Status);
            document.getElementById("vip_change").checked = parseInt(response[0].VIP);
            document.getElementById("select_color_change").value = parseInt(response[0].ColorId);
            $("#change_height").val(response[0].Height);
            $("#change_year").val(response[0].Year);

            findCitiesForCountryInProduct(response[0].CountryId, response[0].CityId);

            var elem = document.getElementById('change_product_title_name');
            var titleNames = elem.getElementsByTagName('input');
            var tags = elem.getElementsByTagName('a');

            var elem2 = document.getElementById('change_product_description');
            var descriptions = elem2.getElementsByTagName('textarea');

            for (index in response) {
                for (i in tags) {
                    if (tags[i].text === response[index].Tag)  {
                        titleNames[i].value = response[index].ProductTitleName;
                        tags[i].name = response[index].ProductLocalizationId;
                        descriptions[i].value = response[index].Description;

                    }
                }
            }
        }
    });
}

function findCitiesForCountryInProduct(countryId, cityId) {
    $('#dropdownCityForProductChange').empty();
    $("#dropdownCountryForProductChange .active").removeClass("active");
    $("#dropdownCountryForProductChange #" + countryId).addClass("active");

    var data = [];
    data.push({CountryId: countryId});
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
                if (parseInt(cityId) === response[index].Id) {
                    htmlCities += '<a id="'+response[index].Id+'" onclick="selectCityForProduct(this.id)" class="dropdown-item active" style="cursor: pointer">'+response[index].Name+'</a>'
                } else {
                    htmlCities += '<a id="'+response[index].Id+'" onclick="selectCityForProduct(this.id)" class="dropdown-item" style="cursor: pointer">'+response[index].Name+'</a>'
                }
            }
            $(htmlCities).appendTo('#dropdownCityForProductChange');
        }
    });
}

function selectCityForProduct(id) {
    $("#dropdownCityForProductChange .active").removeClass("active");
    $("#dropdownCityForProductChange #" + id).addClass("active");
}

