var senhaId = null,
    showSecretEnable = false;

// Formulario
$('#form').form({
    afterSave: function (result) {
        if (!result.errors) {
            $('#modal').modal('hide');
            dataTable.ajax.reload((showSecretEnable ? showSecret(dataTable.rows({selected: true}).data()[0]) : null), false);
        }
    },
    afterDelete: function (result) {
        if (!result) {
            dataTable.ajax.reload(null, false);
            if (showSecretEnable) {
                removeDivSecret();
            }
        }
    }
});

$('#txtTipo').selectize({
    onChange: function (value) {
        $('#form')
            .find('.show')
            .addClass('d-none')
            .end()
            .find('.show-' + value)
            .removeClass('d-none');
    }
});

// Início ajuste passwords
var options = {};
options.ui = {
    container: '.pwd-container',
    showVerdicts: false,
    viewports: {
        progress: '.pwstrength_viewport_progress'
    },
    progressExtraCssClasses: 'progress-sm'
};

$('.txtPassword').pwstrength(options);

$('#generatePassword').pGenerator({
    'bind': 'click',
    'passwordElement': '#txtPassword',
    'specialChars': false,
    'onPasswordGenerated': function () {
        $('#txtPassword').change();
    }
});

var $pw = $('#txtPassword');
var $t = $('#showPassword ').find('i');

$('#showPassword').click(function () {
    function setOriginalState() {
        $pw.attr('type', 'password');
        $t.addClass('fa-eye').removeClass('fa-eye-slash');
    }

    const isPw = $pw.attr('type') === 'password';

    if (isPw) {
        $pw.attr('type', 'text');
        $t.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        setOriginalState();
    }
});
// Fim ajuste passwords

$('#modal')
    .on('shown.bs.modal', function () {
        $('#txtRecurso').focus();
    })
    .on('hidden.bs.modal', function () {
        $('#form').form().cancel();
    });

// Filtros tabela
$('.filterBy').change(function () {
    dataTable.ajax.reload();
    removeDivSecret();
});
$('.filterByType').change(function () {
    dataTable.ajax.reload();
    removeDivSecret();
});
var passwords = [];
// Tabela
var dataTable = $('#table').DataTable({
    pageLength: 15,
    order: [1, 'asc'],
    ajax: {
        url: 'api/passwords',
        type: 'GET',
        data: function (objParam) {
            total = 0;
            amount = 0;
            passwords = [];
            objParam.data_table = true;

            objParam.filter_by = $('.filterBy:checked').val();

            filterByFolder = $('#filterByFolder').jstree('get_selected');
            if ($.isArray(filterByFolder)) {
                objParam.filter_by_folder = filterByFolder;
            }

            filterByType = [];
            $('.filterByType:checked').each(function (index, value) {
                filterByType.push($(value).attr('data-id'));
            });
            objParam.filter_by_type = filterByType;

            return objParam;
        }
    },
    select: {
        style: 'single'
    },
    rowId: 'id',
    dom: '<\'row\'<\'col-9\'f><\'col-3\'B>>' +
        '<\'row rowTableSecret\'<\'col-12 colTableSecret\'tr>>' +
        '<\'card-footer d-flex align-items-center\'ip>',
    buttons: [],
    columns: [
        {
            orderable: false,
            width: '0',
            render: function (value, display, row) {
                return '<a href="javascript:void(0)" id="favorite-' + row.id + '" title="Add to Favorites" onclick="event.stopPropagation();favorite(' + row.id + ');"><svg xmlns="http://www.w3.org/2000/svg" class="icon ' + (row.favorite ? 'text-yellow' : 'text-muted') + '" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M12 17.75l-6.172 3.245 1.179-6.873-4.993-4.867 6.9-1.002L12 2l3.086 6.253 6.9 1.002-4.993 4.867 1.179 6.873z"></path></svg></a>';
            }
        },
        {
            title: 'Passwords',
            data: 'name',
            width: '60%'
        },
        {
            data: 'id',
            orderable: false,
            className: 'text-right',
            width: '40%',
            render: function (value, display, row) {
                let password = '';
                if (![2, 3, 4, 6, 7].includes(row['type'])) return '<span>Can not evaluate strengthㅤ</span><a href="javascript:void(0)" value="' + row['id'] + '" class="btn btn-white btn-icon btn-sm mr-2 show' + (!row.can_view ? 'disabled' : '') + '" title="View" ' + (!row.can_view ? 'disabled' : '') + '><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="12" cy="12" r="2"></circle><path d="M2 12l1.5 2a11 11 0 0 0 17 0l1.5 -2"></path><path d="M2 12l1.5 -2a11 11 0 0 1 17 0l1.5 2"></path></svg></a>';
                delay(1000).then(() => getPassword(row));
                return '<div>' +
                    '<input type="text" id="pass' + row.id + '" class="form-control txtPassword" name="password" maxlength="160" value="" disabled>' +
                    '</div>' +
                    '<div id="pwd-container' + row.id + '">' +
                    '   <div id="pwstrength_viewport_progress' + row.id + '"></div>' +
                    '</div>';
            }
        }
    ],
    drawCallback: function () {
        $('[data-toggle="popover"]').popover();
    }
});
var total = 0;
var amount = 0;

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}

function getPassword(row) {

    $.request({
        url: '/api/passwords/' + row.id,
        after: function (data) {
            if (data['password']) {
                let password = data['password'];
                let id = "#pass" + row.id;
                $(id).val(password)

                var options = {};
                options.ui = {
                    container: '#pwd-container' + row.id,
                    showVerdicts: false,
                    viewports: {
                        progress: '#pwstrength_viewport_progress' + row.id
                    },
                    progressExtraCssClasses: 'progress-sm'
                };
                if ($('#pwstrength_viewport_progress' + row.id)[0].innerHTML == '') {
                    $(id).pwstrength(options);
                    let child = $($('#pwstrength_viewport_progress' + row.id)[0]).children().children();
                    console.log(child.width() / child.parent().width() * 100);
                    total += child.width() / child.parent().width() * 100;
                    amount += 1;

                    console.log(data)

                    const date = new Date(data['updated_at']); // Your date goes here
                    const formattedDate = formatDate(date);
                    console.log(formattedDate);
                    let strength = "";
                    let strengthDouble = child.width() / child.parent().width() * 100;
                    let color = ""
                    if (strengthDouble < 25) {
                        strength = "Weak"
                        color = "#dc3545"
                    }
                    else if (strengthDouble < 50) {
                        strength = "Medium"
                        color = "#ffc107"
                    } else if (strengthDouble < 75) {
                        strength = "Good"
                        color = "#007bff"
                    } else {
                        strength = "Secured"
                        color = "#28a745"
                    }
                        // if (child.width() / child.parent().width() * 100)
                        let content = "<div style='width: 70%; float:right'>" +
                            "<span class='ml-4'>" + formattedDate + "</span>" +
                            "<span class='ml-4' style='width: 35%; white-space: pre; float:right; color: " + color + " '>" +
                            "<i class='fa-solid fa-shield-halved'></i>" + "  " + strength + "" +
                            "</span>";
                    if (data['url']) {
                        content += "<a id='link" + row.id + " ' target='_blank' href=' " + data['url'] + " ' class='float-right'><i class='fa-solid fa-arrow-up-right-from-square'></i></a>";
                        // $("#percent").val("100")
                    }
                    console.log()
                    let percentage = total / amount;
                    percentage = percentage.toPrecision(2);
                    setBarPercentage(percentage);
                    let container = $("tr#" + row.id + " > td");
                    if (passwords.includes(password)) {
                        content += "<i style='font-size: 1.2rem; color: red; float:left' class='fa-solid fa-circle-exclamation alertooltip'><span class='tooltiptext'>Duplicate password</span></i>"
                    }
                    passwords.push(password)
                    container[1].innerHTML += content + '</div>';
                }


            }
        }
    });
}

function formatDate(date) {
    const now = new Date(); // Current date and time
    const diff = now - date; // Time difference in milliseconds

    // Convert the time difference to days
    const days = Math.floor(diff / (24 * 60 * 60 * 1000));

    if (days === 0) {
        // Less than a day ago, calculate hours
        const hours = Math.floor(diff / (60 * 60 * 1000));
        if (hours === 0) {
            // Less than an hour ago, calculate minutes
            const minutes = Math.floor(diff / (60 * 1000));
            if (minutes === 0) {
                // Less than a minute ago, calculate seconds
                const seconds = Math.floor(diff / 1000);
                return seconds + " seconds ago";
            }
            return minutes + " minutes ago";
        }
        return hours + " hours ago";
    }

    // More than a day ago, return the days
    return days + " days ago";
}

// Example usage


$('#table')
    .on('click', 'tbody > tr', function () {
        let $this = $(this);

        if ($this.find('td').hasClass('dataTables_empty')) {
            return;
        }

        if ($this.hasClass('selected')) {
            removeDivSecret();
            return;
        }

        if (!showSecretEnable) {
            showDivSecret();
        }

        let secret = dataTable.row(this).data();

        showSecret(secret);
    });

$.request({
    url: '/api/folders/compact',
    after: function (result) {
        var data = [];

        $.each(result, function (index, value) {
            data.push({'id': value.id, 'parent': value.folder_id || '#', 'text': value.name});
        });

        var filterByFolder = $('#filterByFolder').jstree({
            core: {
                data: data,
                animation: 0,
                themes: {
                    stripes: false,
                    icons: false,
                    dots: false
                }
            },
            checkbox: {
                keep_selected_style: false
            },
            plugins: ['checkbox']
        });

        filterByFolder
            .on('select_node.jstree', function () {
                dataTable.ajax.reload();
                removeDivSecret();
            })
            .on('deselect_node.jstree', function () {
                dataTable.ajax.reload();
                removeDivSecret();
            });
    }
});

function create() {
    $('#modal').modal('show');
}

function edit(id) {
    $('#modal').modal('show');
    $('#form').form().open(id);
}

function remove(id) {
    $('#form').form().delete(id);
}

function share(id) {
    senhaId = id;
    $('#modalCompartilhar').modal('show');
}

function favorite(id) {
    $.request({
        url: '/api/passwords/' + id + '/favorite',
        method: 'POST',
        after: function () {
            $('#favorite-' + id).find('svg').toggleClass('text-yellow text-muted');
        }
    });
}

function showDivSecret() {
    $('.colTableSecret').removeClass('col-12').addClass('col-5');
    $('.rowTableSecret').append('<div class="col-7" id="colDivShowSecret"><div class="card border-bottom-0 border-right-0 h-full" id="divShowSecret"></div></div>');
    showSecretEnable = true;
}

function removeDivSecret() {
    $('.colTableSecret').removeClass('col-7').addClass('col-12');
    $('.rowTableSecret').find('#colDivShowSecret').remove();
    showSecretEnable = false;
}

function showSecret(secret) {
    let $divShowSecret = $('.rowTableSecret').find('#divShowSecret');

    $divShowSecret.empty();
    $divShowSecret.append('<div class="loader my-auto mx-auto"></div>');

    $.request({
        url: '/api/passwords/' + secret.id,
        after: function (data) {
            let html = '';
            let label = '';
            let name = '';
            let isPassword = false;

            // header
            html += '<div class="card-header border-0">' +
                '<h3 class="card-title">' + data.name + '</h3>' +
                '<div class="card-actions">' +
                '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm pull-right" title="Close" onclick="removeDivSecret()"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></a>' +
                '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm pull-right mr-2 ' + (!secret.can_delete ? 'disabled' : '') + '" title="Delete" ' + (!secret.can_delete ? 'disabled' : '') + ' onclick="remove(' + secret.id + ')"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg></a>' +
                '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm pull-right mr-2 ' + (!secret.can_edit ? 'disabled' : '') + '" title="Edit" ' + (!secret.can_edit ? 'disabled' : '') + ' onclick="edit(' + secret.id + ')"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path><line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line></svg></a>' +
                '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm pull-right mr-2 ' + (!secret.can_share ? 'disabled' : '') + '" title="Share" ' + (!secret.can_share ? 'disabled' : '') + ' onclick="share(' + secret.id + ')"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="6" r="3"></circle><circle cx="18" cy="18" r="3"></circle><line x1="8.7" y1="10.7" x2="15.3" y2="7.3"></line><line x1="8.7" y1="13.3" x2="15.3" y2="16.7"></line></svg></a>' +
                '</div>' +
                '</div>';

            // body
            html += '<div class="card-body"><dl class="row">';

            html += '<dt class="col-4">Type:</dt>' +
                '<dd class="col-8">' + data.type_name + '</dd>' +
                '<dt class="col-4">Name: </dt>' +
                '<dd class="col-8">' + data.name + '</dd>';

            $('#form').find('.show-' + data.type).each(function (index) {
                label = $(this).find('label').text();
                name = $(this).find('input').attr('name');
                isPassword = name === 'password';

                if (data[name] !== null) {
                    if (isPassword) {
                        html += '<dt class="col-4">' + label + ': </dt>' +
                            '<dd class="col-8">' +
                            '<span class="pass-' + index + (!isPassword ? ' d-none' : '') + ' show">' + '*'.repeat(data[name].length) + '</span>' +
                            '<span class="pass-' + index + (isPassword ? ' d-none' : '') + ' hidden" id="copy-' + index + '">' + data[name] + '</span>' +
                            '<a href="javascript:void(0)" class="ml-2 showPass" data-index="' + index + '"><i class="fa fa-eye"></i></a>' +
                            '<a href="javascript:void(0)" class="ml-2 copy" data-index="' + index + '"><i class="fa fa-copy"></i>' +
                            '</a>' +
                            '</dd>';
                    }
                    console.log(data[name]);
                    if (name === "url" || name === "URL") {
                        html += '<dt class="col-4 ' + (isPassword ? 'd-none' : '') + '">' + label + ': </dt>' +
                            '<dd class="col-8 ' + (isPassword ? 'd-none' : '') + '"><a href="' + data[name] + '" target="_blank" class="ml-2"><span id="copy-' + index + '">' + data[name] + '</span>ㅤ<i class="fa-solid fa-arrow-up-right-from-square"></i></a></dd>';
                    } else {
                        html += '<dt class="col-4 ' + (isPassword ? 'd-none' : '') + '">' + label + ': </dt>' +
                            '<dd class="col-8 ' + (isPassword ? 'd-none' : '') + '"><span id="copy-' + index + '">' + data[name] + '</span><a href="javascript:void(0)" class="ml-2 copy" data-index="' + index + '"><i class="fa fa-copy"></a></i></dd>';
                    }
                }

            });
            if (data.notes !== null) {
                html += '<dd class="col-12">' + data.notes + '</dd>';
            }

            html += '</dl></div>';

            $divShowSecret.empty();
            $divShowSecret.append(html);

            $divShowSecret.on('click', '.showPass', function () {
                let button = $(this);
                let passShow = $divShowSecret.find('.pass-' + $(this).attr('data-index') + '.show');
                let passHidden = $divShowSecret.find('.pass-' + $(this).attr('data-index') + '.hidden');

                button.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                passShow.toggleClass('d-none');
                passHidden.toggleClass('d-none');

                setTimeout(function () {
                    button.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                    passShow.removeClass('d-none');
                    passHidden.addClass('d-none');
                }, 3500);
            });

            $divShowSecret.on('click', '.copy', function () {
                let button = $(this);

                if (copy($divShowSecret, $divShowSecret.find('#copy-' + $(this).attr('data-index')).text())) {
                    button.find('i').removeClass('fa-copy').addClass('fa-check-circle');
                    setTimeout(function () {
                        button.find('i').removeClass('fa-check-circle').addClass('fa-copy');
                    }, 500);
                }
            });
        }
    });
}

function setBarPercentage(val) {
    var $circle = $('#svg #bar');

    if (isNaN(val)) {
        val = 0;
    } else {
        var r = $circle.attr('r');
        var c = Math.PI * (r * 2);

        if (val < 0) {
            val = 0;
        }
        if (val > 100) {
            val = 100;
        }
        let textHolder = $('#statusText')[0];
        let bar = $('#bar');
        if (val < 25) {
            bar.css("stroke", "red")
            textHolder.innerHTML = "Unsecure: you need to change your passwords to more complicated combinations of symbols";
        } else if (val < 50) {
            bar.css("stroke", "orange")
            textHolder.innerHTML = "Slightly secured: you need to change most of your passwords to more complicated combinations of symbols";
        } else if (val < 75) {
            bar.css("stroke", "blue")
            textHolder.innerHTML = "Satisfied security: even though your passwords are pretty secured, you can change them to be more secured";
        } else {
            bar.css("stroke", "green")
            textHolder.innerHTML = "Secured: all of your passwords are pretty secured";
        }
        console.log($('#statusText')[0].innerHTML);
        var pct = ((100 - val) / 100) * c;

        $circle.css({strokeDashoffset: pct});

        $('#cont').attr('data-pct', val);
    }
}
