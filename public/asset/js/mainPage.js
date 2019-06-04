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