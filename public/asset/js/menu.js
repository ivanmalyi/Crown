function addMenuText() {
    var elem = document.getElementById('menu-text');
    var tags = elem.getElementsByTagName('a');

    var menuLocalizations = [];
    for (index in tags) {

        var tag = tags[index].name;
        if (tag !== undefined && tag !== '' && tag !== 'item' && tag !== 'namedItem') {

            var language = $("#menu-text #" + tag + ' #language').val();
            var from = $("#menu-text #" + tag + ' #from').val();
            var to = $("#menu-text #" + tag + ' #to').val();
            var year = $("#menu-text #" + tag + ' #year').val();
            var height = $("#menu-text #" + tag + ' #height').val();
            var color = $("#menu-text #" + tag + ' #color').val();
            var country = $("#menu-text #" + tag + ' #country').val();
            var city = $("#menu-text #" + tag + ' #city').val();
            var search = $("#menu-text #" + tag + ' #search').val();
            var show = $("#menu-text #" + tag + ' #show').val();
            var contacts = $("#menu-text #" + tag + ' #contacts').val();
            var name = $("#menu-text #" + tag + ' #name').val();
            var description = $("#menu-text #" + tag + ' #description').val();

            menuLocalizations.push({
                Tag: tag,
                Language: language,
                From: from,
                To: to,
                Year: year,
                Height: height,
                Color: color,
                Country: country,
                City: city,
                Search: search,
                Show: show,
                Contacts: contacts,
                Name: name,
                Description: description

            });
        }
    }
    var data = JSON.stringify(menuLocalizations);
    var command = 'UpdateMenu';
    var isSave = confirm("Хотите обновить?");

    if (isSave) {
        $.ajax({
            type: "GET",
            url: '/MenuAction',
            data: '?command=' + encodeURIComponent(command) + '&data=' + encodeURIComponent(data),
            success: function (response) {
                if (parseInt(response) === 1) {
                    alert('Обновлено');
                } else {
                    alert('Не удалось обновить');
                }
            }
        });
    }
}