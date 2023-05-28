var tableCompartilhamentos;

$('#modalCompartilhar')
    .on('shown.bs.modal', function () {
        carregarCompartilhamentos();
    })
    .on('hidden.bs.modal', function () {
    });

function carregarCompartilhamentos() {
    tableCompartilhamentos.block();
    tableCompartilhamentos.api().ajax.url('api/passwords/' + senhaId + '/shareds').load(function () {
        tableCompartilhamentos.unblock();
    });
}

tableCompartilhamentos = $('#tableCompartilhamentos').dataTable({
    autoWidth: false,
    order: [],
    deferLoading: 0,
    dom: "<'row'<'col-8'f><'col-4'B>>" +
        "<'row'<'col-12'tr>>" +
        "<'card-footer d-flex align-items-center'ip>",
    buttons: [
        {
            text: '<button class="btn btn-primary w-xs float-right" id="btnGruposAdicionar"><i class="fe fe-users mr-1"></i>Group</button>'
        },
        {
            text: '<button class="btn btn-white w-xs float-right mr-2" id="btnUsuariosAdicionar"><i class="fe fe-user mr-1"></i>User</button>'
        }
    ],
    paging: false,
    columns: [
        {
            width: '45%',
            render: function (value, display, row) {
                return row.group_name ? ('<i class="fe fe-users mr-2" title="Grupo"></i>' + row.group_name) : ('<i class="fe fe-user mr-2" title="User"></i>' + row.user_name);
            }
        },
        {
            width: '55%',
            orderable: false,
            render: function (value, display, row) {
                return '<div>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" ' + (row.can_view ? 'checked' : '') + ' disabled>' +
                    '<span class="custom-control-label">View</span>' +
                    '</label>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" ' + (row.can_edit ? 'checked' : '') + ' disabled>' +
                    '<span class="custom-control-label">Edit</span>' +
                    '</label>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" ' + (row.can_delete ? 'checked' : '') + ' disabled>' +
                    '<span class="custom-control-label">Delete</span>' +
                    '</label>' +
                    '<label class="custom-control custom-checkbox custom-control-inline mb-0">' +
                    '<input type="checkbox" class="custom-control-input" ' + (row.can_share ? 'checked' : '') + ' disabled>' +
                    '<span class="custom-control-label">Share</span>' +
                    '</label>' +
                    '</div>';
            }
        },
        {
            data: 'id',
            orderable: false,
            className: 'text-right',
            render: function (value) {
                return '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm btnExcluir" data-id="' + value + '" title="Exclude"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg></a>';
            }
        }
    ]
});

tableCompartilhamentos.on('click', 'tbody > tr .btnExcluir', function (event) {
    let $modalContent = $('#modalCompartilhar').find('.modal-content');
    let id = $(this).attr('data-id');

    if (!id || !confirm("Do you really want to delete?")) {
        return;
    }

    $.request({
        url: 'api/passwords/' + id + '/shareds',
        method: 'DELETE',
        error: function () {
            $modalContent.unblock();
        },
        after: function () {
            $.notify({message: 'Share deleted'}, {type: 'success'});
            $modalContent.unblock();
            carregarCompartilhamentos();
        }
    });

    event.stopPropagation();
});
