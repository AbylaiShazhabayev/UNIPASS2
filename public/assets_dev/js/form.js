jQuery.fn.extend({
    form: function (params) {
        if ($(this).data("form") != undefined) {
            return $(this).data("form");
        }

        // parameters
        var defaults = {
            idField: $(this).find(":input[name=id]"), validate: undefined, notify: true, criar: true, editar: true, filho: false,

            afterCancel: function () {
            }, beforeCancel: function () {
            }, afterSave: function () {
            }, beforeSave: function () {
            }, afterOpen: function () {
            }, beforeOpen: function () {
            }, afterDelete: function () {
            }, beforeDelete: function () {
            }, after: function () {
            }, error: function () {
            }
        };

        $.extend(defaults, params, {
            form: $(this)
        }, {
            open: function (id) {
                defaults.form.block();

                (defaults.editar ? defaults.enable() : defaults.disable());

                defaults.beforeOpen(defaults);

                $.ajax({
                    url: defaults.form.attr("name") + '/' + id, type: 'GET', dataType: 'JSON', error: function (objResult) {
                        $.notify({message: objResult.status + ' - ' + objResult.statusText}, {type: 'danger'});
                        defaults.form.unblock();
                    }, success: function (result) {
                        if (!result.errors) {
                            var objInput;

                            try {
                                $.each(result, function (strKey, mixValue) {
                                    objInput = defaults.form.find(":input[name='" + strKey + "']");

                                    if (objInput.hasClass('moeda')) {
                                        objInput.val(parseFloat(mixValue).toFixed(2));
                                        objInput.maskMoney('mask');
                                    } else if (objInput.attr('type') == 'checkbox') {
                                        objInput.prop('checked', mixValue == objInput.attr('value-true'));
                                    } else if (objInput.attr('type') == 'radio') {
                                        objInput.each(function (index, el) {
                                            $(el).prop('checked', mixValue == $(el).attr('value-true'));
                                        });
                                    } else if (objInput.hasClass('selectized')) {
                                        if (objInput.attr('type')) {
                                            if (objInput.hasClass('default-value')) {
                                                objInput[0].selectize.setValue(mixValue.split(','));
                                            } else {
                                                objInput[0].selectize.clearOptions();
                                                $.each(mixValue.split(','), function (index, value) {
                                                    objInput[0].selectize.createItem(value);
                                                });
                                            }
                                        } else {
                                            objInput[0].selectize.setValue(mixValue);
                                        }
                                    } else if (objInput.hasClass('cpf')) {
                                        objInput.unmask();
                                        objInput.val(mixValue);
                                        objInput.mask('000.000.000-00');
                                    } else if (objInput.attr('type') == 'date') {
                                        objInput.val(moment(mixValue).format('YYYY-MM-DD'));
                                    } else {
                                        objInput.val(mixValue);
                                    }
                                });
                            } catch (objResult) {
                            }

                            defaults.form.unblock();
                        } else {
                            $.notify({message: 'Something wrong happened'}, {type: 'danger'});
                            defaults.form.unblock();
                        }
                        defaults.afterOpen(result, defaults);
                        defaults.after(result, defaults, "open");
                    }
                });
            }, cancel: function () {
                defaults.form.block();

                ((defaults.criar && !defaults.filho) || (defaults.editar && defaults.filho) ? defaults.enable() : defaults.disable());

                defaults.beforeCancel(defaults);

                defaults.form.find('.selectize-input').removeClass('error');
                defaults.form.find(":input[name!=''][name!='_token']:not(button)").each(function () {
                    var objInput = $(this);

                    objInput.removeClass('is-invalid');

                    if (objInput.attr('type') == 'checkbox') {
                        objInput.prop('checked', false);
                    } else if (objInput.attr('type') == 'radio') {
                        objInput.prop('checked', objInput.attr('checked') ? true : false);
                    } else if (objInput.parents('.selectize-input').length) {
                        objInput.parents('.selectize-control').prev()[0].selectize.clear();
                    } else {
                        objInput.val("");
                    }
                });

                defaults.validate.resetForm();

                defaults.form.unblock();

                defaults.afterCancel(defaults);
                defaults.after(defaults, "cancel");
            }, serializeObject: function () {
                var objData = {}, objInput;

                defaults.form.find(":input[name!=''][name!='fileuploader-list-arquivo'][type!='file']:not(button)").each(function () {
                    objInput = $(this);
                    if (objData[objInput.attr("name")] == undefined && !(objInput.attr("name") == undefined || (objInput.attr("name") == "id" && objInput.val() == "") || (objInput.attr("name") == defaults.idField.attr('name') && objInput.val() == ""))) {
                        if (objInput.attr('type') == 'checkbox') {
                            objData[objInput.attr("name")] = (objInput.is(':checked') ? objInput.attr('value-true') : objInput.attr('value-false'));
                        } else if (objInput.attr('type') == 'radio') {
                            if (objInput.is(":checked")) {
                                objData[objInput.attr("name")] = objInput.attr('value-true');
                            }
                        } else if (objInput.hasClass('cpf')) {
                            objData[objInput.attr("name")] = objInput.cleanVal();
                        } else if (objInput.hasClass('moeda')) {
                            objData[objInput.attr("name")] = objInput.maskMoney('unmasked')[0];
                        } else {
                            objData[objInput.attr("name")] = objInput.val();
                        }
                    }
                });

                return objData;
            }, save: function () {
                defaults.form.block();

                var booIsPut = Boolean(defaults.idField.val());

                defaults.beforeSave(defaults);
                $.ajax({
                    url: defaults.form.attr("name") + (booIsPut ? '/' + defaults.idField.val() : ''),
                    type: (booIsPut ? 'PUT' : 'POST'),
                    data: defaults.serializeObject(),
                    dataType: 'JSON',
                    error: function (result) {
                        let message = '';

                        if (result.status == 422) {
                            $.each(result.responseJSON.errors, function (index, value) {
                                message += (message != '' ? '<br>' : '') + value;
                            });
                        } else if (result.errors) {
                            message = result.errors;
                        } else {
                            message = result.status + ' - ' + result.statusText;
                        }

                        $.notify({message: message}, {type: 'danger'});
                        defaults.form.unblock();
                    },
                    success: function (result) {
                        var message = 'Record ' + (booIsPut ? 'Denied' : 'Success');

                        if (defaults.notify) {
                            if (!result.errors) {
                                if (result.mensagem) {
                                    message += ('<br>' + result.mensagem);
                                }
                                $.notify({message: message}, {type: 'success'});
                                (defaults.editar ? defaults.enable() : defaults.disable());
                            } else {
                                $.notify({message: result.mensagem}, {type: 'danger'});
                            }
                        }

                        defaults.form.unblock();

                        defaults.afterSave(result, defaults);
                        defaults.after(result, defaults, "save");
                    }
                });
            }, delete: function (id, params) {
                if (!id || !confirm((params && params.messageConfirm) ? params.messageConfirm : "Are you sure you want to delete")) {
                    return;
                }
                $.blockUI();

                defaults.beforeDelete(defaults);

                $.ajax({
                    url: defaults.form.attr("name") + '/' + id, type: 'DELETE', error: function (result) {
                        let message = '';

                        if (result.status == 422) {
                            $.each(result.responseJSON.errors, function (index, value) {
                                message += (message != '' ? '<br>' : '') + value;
                            });
                        } else if (result.errors) {
                            message = result.errors;
                        } else {
                            message = result.status + ' - ' + result.statusText;
                        }

                        $.notify({message: message}, {type: 'danger'});
                        $.unblockUI();
                    }, success: function (result) {
                        $.notify({message: 'Record removed'}, {type: 'success'});
                        $.unblockUI();

                        defaults.afterDelete(result, defaults);
                        defaults.after(result, defaults, "delete");
                    }
                });
            }, enable: function () {
                defaults.form
                    .find('input:not(.default-disabled), textarea:not(.default-disabled)')
                    .attr('disabled', false)
                    .end()
                    .find('button[type="submit"]:not(.default-disabled)')
                    .attr('disabled', false)
                    .end()
                    .find('.selectized:not(.default-disabled)').each(function () {
                    $(this)[0].selectize.enable();
                });
            }, disable: function () {
                defaults.form
                    .find('input[type!="search"], textarea')
                    .attr('disabled', true)
                    .end()
                    .find('button[type="submit"]')
                    .attr('disabled', true)
                    .end()
                    .find('.selectized:not(.default-disabled)').each(function () {
                    $(this)[0].selectize.disable();
                });
            }
        });

        defaults.form.find('.moeda')
            .maskMoney({
                thousands: '.', decimal: ',', precision: 2
            })
            .addClass('text-right');

        defaults.form.find('input').attr('autocomplete', 'off');
        defaults.form.find('.cpf').mask('000.000.000-00');

        defaults.form.find('.copy').click(function () {
            let _ptmp = $('<input>');
            $('#modal').append(_ptmp);
            _ptmp.val($(this).parent().prev().val()).select();
            document.execCommand("copy");
            _ptmp.remove();
            $.notify('Copy made');
        });

        defaults.form.find('input:not([type="hidden"]), select, textarea').each(function () {
            var objThis = $(this);

            if (objThis.attr('required')) {
                objThis.prev().append('<span class="text-danger"> *</span>');
            }
        });

        defaults.validate = defaults.form.validate({
            focusInvalid: false, ignore: ':hidden, input[type="search"], .disabled input'
        });

        try {
            var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            var recognition = new SpeechRecognition();
            var started = false;
            var text = '';
            var element;
            var icon;

            //recognition.continuous = true;

            defaults.form.find('textarea').each(function () {
                if (!$(this).hasClass('default-disabled') && !$(this).attr('disabled')) {
                    $(this).prev().append('<a id="btnAudio' + $(this).attr('id') + '"><i class="fe fe-mic ml-1"></i></a><span class="si-audio-duracao m-l-xs hidden"></span>');

                    $('#btnAudio' + $(this).attr('id')).click(function () {
                        element = $(this).parent().next();
                        icon = $(this).next();

                        if (started) {
                            recognition.stop();
                            started = false;
                            text = '';
                            $('.si-audio-duracao').addClass('hidden');
                        } else {
                            recognition.start();
                            started = true;
                            text = element.val() + (element.val() != '' ? ' ' : '');
                        }
                    });

                    recognition.onstart = function () {
                        icon.removeClass('hidden');
                    };

                    recognition.onspeechend = function () {
                        recognition.stop();
                        started = false;
                        $('.si-audio-duracao').addClass('hidden');
                    };

                    recognition.onresult = function (event) {
                        var current = event.resultIndex;
                        var transcript = event.results[current][0].transcript;

                        var mobileRepeatBug = (current == 1 && transcript == event.results[0][0].transcript);

                        if (!mobileRepeatBug) {
                            text += transcript;
                            element.val(text);
                        }
                    }
                }
            });
        } catch (e) {
        }

        defaults.form
            .on("reset", function () {
                defaults.cancel();

                return false;
            })
            .on("submit", function () {
                defaults.form.find('input[type=text]').each(function () {
                    $(this).val($.trim($(this).val()));
                });

                if (defaults.form.find('.moeda').val() == '0,00') {
                    defaults.form.find('.moeda').val('');
                }

                if (defaults.form.valid()) {
                    defaults.form.form().save();
                }

                return false;
            });

        return $(this)
            .data("form", defaults)
            .data("form");
    }
});
