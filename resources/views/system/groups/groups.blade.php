@extends('app')

@section('content')
    @include('system.groups.groups-add-users')

    <div id="modalGrupo" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"></path>
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <form id="formGrupo" name="api/groups" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="txtGrupoId">

                    <div class="modal-body">
                        <label class="form-label" for="txtGrupoDescricao">Name</label>
                        <input type="text" class="form-control" name="name" id="txtGrupoDescricao"
                               maxlength="64" required>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-white mr-auto w-xs" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-white" onclick="saveAndAddUser=true">Save and users</button>
                        <button type="submit" class="btn btn-primary w-xs" onclick="saveAndAddUser=false">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalGrupoUsuarios" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Group users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z"></path>
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <table id="tableGruposUsuarios"
                       class="table table-hover table-outline table-vcenter text-nowrap card-table w-100 border-top">
                    <thead>
                    <th>Users</th>
                    <th></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card w-75 mx-auto">
        <table id="tableGrupos"
               class="table card-table table-vcenter text-nowrap datatable table-hover border-top">
            <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        var can_create = "{{ auth()->user()->can('group-create') }}",
            can_edit = "{{ auth()->user()->can('group-edit') }}",
            can_delete = "{{ auth()->user()->can('group-delete') }}";

        $.getScript("{{ asset($assets . '/js/groups.js?') . $version }}");
    </script>
@endsection
