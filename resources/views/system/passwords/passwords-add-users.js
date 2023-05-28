var tableUsuariosDisponiveis,
    checkAdicionarUsuario;

$('#btnUsuariosAdicionar').click(function () {
    $('#modalUsuariosDisponiveis').modal('show');
    carregarUsuariosDisponiveis();
    checkAdicionarUsuario = [];
});

function carregarUsuariosDisponiveis() {
    tableUsuariosDisponiveis.block();
    tableUsuariosDisponiveis.api().ajax.url('api/passwords/' + senhaId + '/users/available').load(function () {
        tableUsuariosDisponiveis.unblock();
    });
}

tableUsuariosDisponiveis = $('#tableUsuariosDisponiveis').dataTable({
    autoWidth: false,
    order: [1, 'asc'],
    deferLoading: 0,
    buttons: [],
    columns: [
        {
            data: 'id',
            orderable: false,
            render: function (value) {
                return '<label class="custom-control custom-checkbox m-0">' +
                    '<input type="checkbox" class="custom-control-input btnCheckUsuario" data-id="' + value + '">' +
                    '<span class="custom-control-label">&nbsp;</span>' +
                    '</label>';
            }
        },
        {
            data: 'name',
            width: '45%'
        },
        {
            data: 'id',
            width: '55%',
            orderable: false,
            render: function (value) {
                return '<div data-user="' + value + '">' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" name="can_view" checked disabled>' +
                    '<span class="custom-control-label">View</span>' +
                    '</label>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" name="can_edit">' +
                    '<span class="custom-control-label">Edit</span>' +
                    '</label>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" name="can_delete">' +
                    '<span class="custom-control-label">Delete</span>' +
                    '</label>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" name="can_share">' +
                    '<span class="custom-control-label">Share</span>' +
                    '</label>' +
                    '</div>';
            }
        }
    ],
    drawCallback: function () {
        var $table = $('#tableUsuariosDisponiveis');

        $table.find('input[name="can_view"], input[name="can_edit"], input[name="can_delete"], input[name="can_share"]').on('change', function () {
            let div = $(this).parents('div');
            let usuarioId = div.attr('data-user');

            checkAdicionarUsuario = checkAdicionarUsuario.filter(function (item) {
                if (item.user_id == usuarioId) {
                    item.can_view = (div.find('input[name="can_view"]').is(':checked') ? 1 : 0);
                    item.can_edit = (div.find('input[name="can_edit"]').is(':checked') ? 1 : 0);
                    item.can_delete = (div.find('input[name="can_delete"]').is(':checked') ? 1 : 0);
                    item.can_share = (div.find('input[name="can_share"]').is(':checked') ? 1 : 0);
                }
                return true;
            });
        });
    }
});

tableUsuariosDisponiveis.on('click', 'tbody > tr .btnCheckUsuario', function () {
    var usuarioId = $(this).attr('data-id');

    if ($(this).is(':checked')) {
        checkAdicionarUsuario.push({
            'password_id': senhaId,
            'user_id': usuarioId,
            'can_view': ($(this).parents('tr').find('input[name="can_view"]').is(':checked') ? 1 : 0),
            'can_edit': ($(this).parents('tr').find('input[name="can_edit"]').is(':checked') ? 1 : 0),
            'can_delete': ($(this).parents('tr').find('input[name="can_delete"]').is(':checked') ? 1 : 0),
            'can_share': ($(this).parents('tr').find('input[name="can_share"]').is(':checked') ? 1 : 0)
        });
    } else {
        checkAdicionarUsuario = checkAdicionarUsuario.filter(function (item) {
            return item.user_id != usuarioId;
        });
    }

    $('#btnUsuariosSalvar').toggleClass('disabled', checkAdicionarUsuario.length === 0);
});

$('#btnUsuariosSalvar').click(function () {
    let data = 'shareds=' + JSON.stringify(checkAdicionarUsuario);
    let $modal = $('#modalUsuariosDisponiveis');
    let $modalContent = $modal.find('.modal-content');

    $modalContent.block();
    $.request({
        url: 'api/passwords/' + senhaId + '/shareds',
        method: 'POST',
        data: data,
        error: function () {
            $modalContent.unblock();
        },
        after: function () {
            $.notify({message: 'Password shared'}, {type: 'success'});

            carregarCompartilhamentos();
            $modal.modal('hide');

            $modalContent.unblock();
        }
    });
});
