function addCountry() {
    var elem = document.getElementById('country_title_name');
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