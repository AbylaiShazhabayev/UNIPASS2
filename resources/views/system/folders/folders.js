// Formúlario
$('#formFolder').form({
    afterSave: function () {
        dataTable.api().ajax.reload();
        $('#modalFolder').modal('hide');

        $('#txtFolderId')[0].selectize.clearOptions();
        $('#txtFolderId')[0].selectize.onSearchChange('');
    },
    afterDelete: function () {
        dataTable.api().ajax.reload();

        $('#txtFolderId')[0].selectize.clearOptions();
        $('#txtFolderId')[0].selectize.onSearchChange('');
    }
});

$('#modalFolder')
    .on('shown.bs.modal', function () {
        $('#txtNome').focus();
    });

// Tabela
var dataTable = $('#tableFolder').dataTable({
    ajax: {
        url: '/api/folders',
        type: 'GET',
        data: function (objParam) {
            objParam.is_data_table = true;
            return objParam;
        }
    },
    buttons: [
        {
            text: '<button class="btn btn-primary w-xs float-right" id="btnNewFolder" ' + (!can_create ? 'disabled' : '') + '>New</button>'
        }
    ],
    // pageLength: 50,
    // info: false,
    paginate: false,
    ordering: false,
    columns: [
        {
            data: 'name',
            width: '100%'
        },
        {
            data: 'id',
            orderable: false,
            className: 'text-right',
            render: function (value) {
                return '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm btnEditar mr-2 ' + (!can_edit ? 'disabled' : '') + '" data-id="' + value + '" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path><line x1="13.5" y1="6.5" x2="17.5" y2="10.5"></line></svg></a>' +
                    '<a href="javascript:void(0)" class="btn btn-white btn-icon btn-sm btnExcluir ' + (!can_delete ? 'disabled' : '') + '" data-id="' + value + '" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z"></path><line x1="4" y1="7" x2="20" y2="7"></line><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg></a>';
            }
        }
    ],
    createdRow: function (row, data) {
        $(row).attr('data-tt-id', data.id);
        $(row).attr('data-tt-parent-id', data.folder_id);
    },
    fnDrawCallback: function () {
        let table = $('#tableFolder');

        table.treetable('destroy');
        table.treetable();
    }
});

$('.dataTables_wrapper').on('click', '#btnNewFolder', function () {
    $('#formFolder').form().cancel();
    $('#modalFolder').modal('show');
});

dataTable
    .on('click', 'tbody > tr .btnEditar', function () {
        $('#modalFolder').modal('show');
        $('#formFolder').form().open($(this).attr('data-id'));
    })
    .on('click', 'tbody > tr .btnExcluir', function (event) {
        $('#formFolder').form().delete($(this).attr('data-id'));

        event.stopPropagation();
    });
