var tableGruposDisponiveis,
    checkAdicionarGrupo;

$('#btnGruposAdicionar').click(function () {
    $('#modalGruposDisponiveis').modal('show');
    carregarGruposDisponiveis();
    checkAdicionarGrupo = [];
});

function carregarGruposDisponiveis() {
    tableGruposDisponiveis.block();
    tableGruposDisponiveis.api().ajax.url('api/passwords/' + senhaId + '/groups/available').load(function () {
        tableGruposDisponiveis.unblock();
    });
}

tableGruposDisponiveis = $('#tableGruposDisponiveis').dataTable({
    autoWidth: false,
    order: [1, 'asc'],
    deferLoading: 0,
    buttons: [],
    columns: [
        {
            data: 'id',
            orderable: false,
            className: 'align-middle v-middle',
            render: function (value) {
                return '<label class="custom-control custom-checkbox m-0">' +
                    '<input type="checkbox" class="custom-control-input btnCheckGrupo" data-id="' + value + '">' +
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
                return '<div data-group="' + value + '">' +
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
                    '<span class="custom-control-label">Exclude</span>' +
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
        var $table = $('#tableGruposDisponiveis');

        $table.find('input[name="can_view"], input[name="can_edit"], input[name="can_delete"], input[name="can_share"]').on('change', function () {
            let div = $(this).parents('div');
            let grupoId = div.attr('data-group');

            checkAdicionarGrupo = checkAdicionarGrupo.filter(function (item) {
                if (item.group_id == grupoId) {
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

tableGruposDisponiveis.on('click', 'tbody > tr .btnCheckGrupo', function () {
    var grupoId = $(this).attr('data-id');

    if ($(this).is(':checked')) {
        checkAdicionarGrupo.push({
            'password_id': senhaId,
            'group_id': grupoId,
            'can_view': ($(this).parents('tr').find('input[name="can_view"]').is(':checked') ? 1 : 0),
            'can_edit': ($(this).parents('tr').find('input[name="can_edit"]').is(':checked') ? 1 : 0),
            'can_delete': ($(this).parents('tr').find('input[name="can_delete"]').is(':checked') ? 1 : 0),
            'can_share': ($(this).parents('tr').find('input[name="can_share"]').is(':checked') ? 1 : 0)
        });
    } else {
        checkAdicionarGrupo = checkAdicionarGrupo.filter(function (item) {
            return item.group_id != grupoId;
        });
    }

    $('#btnGruposSalvar').toggleClass('disabled', checkAdicionarGrupo.length === 0);
});

$('#btnGruposSalvar').click(function () {
    let data = 'shareds=' + JSON.stringify(checkAdicionarGrupo);
    let $modal = $('#modalGruposDisponiveis');
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
