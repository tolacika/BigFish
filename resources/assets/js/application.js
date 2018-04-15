Application = function () {
};

Application.prototype.initApp = function () {
    /*NProgress.configure({
        showSpinner: false,
        template: '<div class="bar nprogress-bar-header nprogress-bar-danger" role="bar"></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'
    });*/
    $(":input").attr('autocomplete', "off");
};

Application.prototype.post = function (settings, method) {
    var options = {
        url: settings.url,
        type: method || "POST",
        data: settings.data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        xhr: function () {
            var xhr = $.ajaxSettings.xhr();
            if (xhr.upload) {
                xhr.upload.addEventListener('progress', function (progress) {
                    if (typeof settings.upload_progress !== 'undefined' &&
                        settings.upload_progress === false) {
                        return;
                    }
                    NProgress.set(progress.loaded / (progress.total || 100));
                }, false);
            }
            return xhr;
        },
        success: function (response, textStatus, jqXHR) {
            if (typeof settings.upload_progress === 'undefined' || (
                    typeof settings.upload_progress !== 'undefined' &&
                    settings.upload_progress !== false)) {
                // Progressbar leállítása
                NProgress.done();
            }
            if (response.fn) {
                eval(response.fn);
            }
            if (response.redirect) {
                window.location.href = response.redirect;
            }
            if (typeof settings.callback === 'function') {
                settings.callback(response, textStatus, jqXHR);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var response = $.parseJSON(jqXHR.responseText);
            console.log(jqXHR, textStatus, errorThrown);
            if (response.status === "401") {
                window.location.reload(true);
                return;
            }
            if (response.message) {
                toastr.error(response.message, "Hiba történt!");
            } else {
                toastr.error("Kérem töltse újra a weblapot", "Hiba történt!");
            }
        }
    };
    if (typeof options.data === 'undefined') {
        options.data = {};
    }
    NProgress.start();

    return $.ajax(options);
};

window.app = new Application();

$(document).ready(function () {
    window.app.initApp();
});