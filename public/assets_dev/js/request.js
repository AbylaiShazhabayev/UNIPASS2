/**
 * Created by Anderson on 5/29/2016.
 */
jQuery.extend({
    request: function (params) {
        var defaults = {
            url: '',
            method: 'GET',
            data: undefined,
            error: function (objResult) {},
            after: function (objResult) {}
        };

        var settings = $.extend({}, defaults, params);

        $.ajax({
            url: settings.url,
            type: settings.method,
            data: settings.data,
            dataType: 'JSON',
            error: function (result) {
                let message = '';

                if (result.status === 422) {
                    $.each(result.responseJSON.errors, function (index, value) {
                        message += (message !== '' ? '<br>' : '') + value;
                    });
                } else if (result.errors) {
                    message = result.errors;
                } else {
                    message = result.status + ' - ' + result.statusText;
                }

                $.notify({message: message}, {type: 'danger'});
                settings.error(result);
            },
            success: function (objResult) {
                settings.after(objResult);
            }
        });
    }
});
