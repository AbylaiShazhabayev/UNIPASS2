@extends('app')

@section('content')
    <div id="modalUsuario" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User</h5>
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

                <form id="formUsuario" name="api/users" role="form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="txtId">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label" for="txtNome">Name</label>
                            <input type="text" class="form-control" name="name" id="txtNome" maxlength="64" required>
                        </div>

                        <div>
                            <label class="form-label" for="txtEmail">Email</label>
                            <input type="email" class="form-control" name="email" id="txtEmail" maxlength="64" required>
                        </div>
                    </div>

                    <div class="modal-body">
                        <p><strong>Permissions</strong></p>

                        <div class="form-group">
                            <div class="form-label mb-1">
                                <label class="form-check mb-0">
                                    <input type="checkbox" id="txtUsuarioAdministrador" name="admin"
                                           class="form-check-input" value-true="1" value-false="0">
                                    <span class="form-check-label">Administrator</span>
                                </label>
                            </div>
                        </div>

                        <div class="d-none" id="divMensagemAdministrador">
                            <div class="alert alert-info" role="alert">
                                Administrators have access to all features.
                                <br>
                                <small>
                                    Like for example:
                                    <ul>
                                        <li>Change company data;</li>
                                        <li>Change the number of plan users;</li>
                                        <li>Change card details;</li>
                                        <li>Remove other admin users.</li>
                                    </ul>
                                </small>
                            </div>
                        </div>

                        <div class="form-group divPermissao">
                            <div class="form-label mb-1">Folders</div>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtFolderVisualizar" name="folder-view"
                                       class="form-check-input" value-true="1"
                                       value-false="0">
                                <span class="form-check-label">Show</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtFolderCriar" name="folder-create"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Create</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtFolderEditar" name="folder-edit"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Update</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtFolderExcluir" name="folder-delete"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Delete</span>
                            </label>
                        </div>

                        <div class="form-group divPermissao">
                            <div class="form-label mb-1">Users</div>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtUsuarioVisualizar" name="user-view"
                                       class="form-check-input" value-true="1" value-false="0">
                                <span class="form-check-label">Show</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtUsuarioCriar" name="user-create"
                                       class="form-check-input default-disabled" value-true="1" value-false="0"
                                       disabled>
                                <span class="form-check-label">Create</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtUsuarioEditar" name="user-edit"
                                       class="form-check-input default-disabled" value-true="1" value-false="0"
                                       disabled>
                                <span class="form-check-label">Update</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtUsuarioExcluir" name="user-delete"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Delete</span>
                            </label>
                        </div>

                        <div class="form-group divPermissao">
                            <div class="form-label mb-1">Groups</div>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtGrupoUsuarioVisualizar" name="group-view"
                                       class="form-check-input" value-true="1"
                                       value-false="0">
                                <span class="form-check-label">Show</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtGrupoUsuarioCriar" name="group-create"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Create</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtGrupoUsuarioEditar" name="group-edit"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Update</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input type="checkbox" id="txtGrupoUsuarioExcluir" name="group-delete"
                                       class="form-check-input default-disabled" value-true="1"
                                       value-false="0" disabled>
                                <span class="form-check-label">Delete</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-white mr-auto w-xs" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary w-xs">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card w-75 mx-auto">
        <table id="tableUsuarios"
               class="table table-hover table-outline table-vcenter text-nowrap card-table border-top">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Altered</th>
                <th></th>
            </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        var user_id = "{{ auth()->user()->id }}",
            can_create = "{{ auth()->user()->can('user-create') }}",
            can_edit = "{{ auth()->user()->can('user-edit') }}",
            can_delete = "{{ auth()->user()->can('user-delete') }}";

        $.getScript("{{ asset($assets . '/js/users.js?') . $version }}");
    </script>
@endsection
