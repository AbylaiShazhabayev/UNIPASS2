var tableUsuariosDisponiveis,
    checkAdicionarUsuario;

$(function () {
    $('#modalUsuariosDisponiveis')
        .on('hidden.bs.modal', function () {
            checkAdicionarUsuario = [];
        })
        .on('shown.bs.modal', function () {
            carregarUsuariosDisponiveis();
            checkAdicionarUsuario = [];
        });

    tableUsuariosDisponiveis = $('#tableUsuariosDisponiveis').dataTable({
        autoWidth: false,
        order: [1, 'asc'],
        deferLoading: 0,
        info: false,
        buttons: [],
        columns: [
            {
                data: 'id',
                orderable: false,
                render: function (value) {
                    return '<input type="checkbox" class="form-check-input btnCheckUsuario" data-id="' + value + '">';
                }
            },
            {
                data: 'name',
                width: '100%'
            }
        ]
    });

    tableUsuariosDisponiveis.on('click', 'tbody > tr .btnCheckUsuario', function () {
        var usuarioId = $(this).attr('data-id');

        if ($(this).is(':checked')) {
            checkAdicionarUsuario.push({
                'user_id': usuarioId
            });
        } else {
            checkAdicionarUsuario = checkAdicionarUsuario.filter(function (item) {
                return item.user_id != usuarioId;
            });
        }

        $('#btnUsuariosSalvar').toggleClass('disabled', checkAdicionarUsuario.length === 0);
    });

    $('#btnUsuariosSalvar').click(function () {
        let data = 'users=' + JSON.stringify(checkAdicionarUsuario);
        let $modal = $('#modalUsuariosDisponiveis');
        let $modalContent = $modal.find('.modal-content');

        $modalContent.block();
        $.request({
            url: '/api/groups/' + grupoId + '/users',
            method: 'POST',
            data: data,
            error: function () {
                $modalContent.unblock();
            },
            after: function () {
                carregarUsuariosDoGrupo();
                $modal.modal('hide');

                $modalContent.unblock();
            }
        });
    });
});

function carregarUsuariosDisponiveis() {
    tableUsuariosDisponiveis.block();
    tableUsuariosDisponiveis.api().ajax.url('api/groups/' + grupoId + '/users/available').load(function () {
        tableUsuariosDisponiveis.unblock();
    });
}
