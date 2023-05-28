$('#formUsuario').form({
    afterOpen: function (data) {
        $('#txtEmail').attr('disabled', true);

        if (data.id == user_id) {
            $('#formUsuario').find('input[type="checkbox"]').attr('disabled', true);
        }

        if (data.admin) {
            $('.divPermissao').addClass('d-none');
            $('#divMensagemAdministrador').removeClass('d-none');
        }

        $('#txtFolderCriar, #txtFolderEditar, #txtFolderExcluir').prop('disabled', !data['folder-view']);
        $('#txtUsuarioCriar, #txtUsuarioEditar, #txtUsuarioExcluir').prop('disabled', !data['user-view']);
        $('#txtGrupoUsuarioCriar, #txtGrupoUsuarioEditar, #txtGrupoUsuarioExcluir').prop('disabled', !data['group-view']);
    },
    afterSave: function () {
        dataTable.api().ajax.reload();
        $('#modalUsuario').modal('hide');

        if (!$('#txtId').val()) {
            $.notify('Invitation sent to use the system');
        }
    },
    afterDelete: function () {
        dataTable.api().ajax.reload();
    },
    afterCancel: function () {
        $('#txtEmail').attr('disabled', false);

        $('.divPermissao').removeClass('d-none');
        $('#divMensagemAdministrador').addClass('d-none');
    }
});

$('#txtUsuarioAdministrador').click(function () {
    $('.divPermissao, #divMensagemAdministrador').toggleClass('d-none');
});

$('#txtFolderVisualizar').click(function () {
    let inputCheckPermissao = $('#txtFolderCriar, #txtFolderEditar, #txtFolderExcluir');

    if ($(this).is(':checked')) {
        inputCheckPermissao
            .prop('checked', true)
            .prop('disabled', false);
    } else {
        inputCheckPermissao
            .prop('checked', false)
            .prop('disabled', true);
    }
});

$('#txtUsuarioVisualizar').click(function () {
    let inputCheckPermissao = $('#txtUsuarioCriar, #txtUsuarioEditar, #txtUsuarioExcluir');

    if ($(this).is(':checked')) {
        inputCheckPermissao
            .prop('checked', true)
            .prop('disabled', false);
    } else {
        inputCheckPermissao
            .prop('checked', false)
            .prop('disabled', true);
    }
});

$('#txtGrupoUsuarioVisualizar').click(function () {
    let inputCheckPermissao = $('#txtGrupoUsuarioCriar, #txtGrupoUsuarioEditar, #txtGrupoUsuarioExcluir');

    if ($(this).is(':checked')) {
        inputCheckPermissao
            .prop('checked', true)
            .prop('disabled', false);
    } else {
        inputCheckPermissao
            .prop('checked', false)
            .prop('disabled', true);
    }
});

$('#modalUsuario')
    .on('shown.bs.modal', function () {
        $('#txtRecurso').focus();
    })
    .on('hidden.bs.modal', function () {
        $('#formUsuario').form().cancel();
    });

var dataTable = $('#tableUsuarios').dataTable({
    pageLength: 15,
    ajax: {
        url: 'api/users',
        type: 'GET',
        data: function (objParam) {
            objParam.is_data_table = true;
            return objParam;
        }
    },
    buttons: [
        {
            text: '<button class="btn btn-primary w-xs float-right" id="btnNovo" ' + (!can_create ? 'disabled' : '') + '>New</button>'
        }
    ],
    columns: [
        {
            data: 'name',
            width: '50%'
        },
        {
            data: 'email',
            width: '50%'
        },
        {
            data: 'updated_at',
            render: function (value) {
                return moment(value).format('L H:mm');
            }
        },
        {
            data: 'id',
            orderable: false,
            className: 'text-right',
            render: function (value) {
                return '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm btnEditar mr-2 ' + (!can_edit ? 'disabled' : '') + '" data-id="' + value + '" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path><line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line></svg></a>' +
                    '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm btnExcluir ' + ((!can_delete || user_id == value) ? 'disabled' : '') + '" data-id="' + value + '" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg></a>';
            }
        }
    ]
});

dataTable
    .on('click', 'tbody > tr .btnEditar', function () {
        var objThis = $(this);

        if (!objThis.find('td:first').hasClass('dataTables_empty')) {
            $('#modalUsuario').modal('show');
            $('#formUsuario').form().open($(this).attr('data-id'));
        }
    })
    .on('click', 'tbody > tr .btnExcluir', function (event) {
        $('#formUsuario').form().delete($(this).attr('data-id'), {
            messageConfirm: 'Do you really want to delete?\n\nATTENTION!\nThis user\'s passwords will be deleted, including passwords that have already been shared!'
        });

        event.stopPropagation();
    })
    .parents('.dataTables_wrapper')
    .on('click', '#btnNovo', function () {
        $('#modalUsuario').modal('show');
    });
