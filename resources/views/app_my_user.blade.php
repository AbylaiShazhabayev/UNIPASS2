<div id="modalAppMyUser" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">My user</h5>
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

            <form id="formMyUser" class="form-validation" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="txtNome">Name</label>
                        <input type="text" class="form-control" name="name" id="txtNome" autocomplete="off"
                               value="{{ Auth::user() ? Auth::user()->name : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="txtEmail">E-mail</label>
                        <input type="email" class="form-control" id="txtEmail" autocomplete="off"
                               value="{{ Auth::user() ? Auth::user()->email : '' }}" disabled>
                    </div>
                </div>
                <div class="modal-body">
                    <p><strong>Change Password</strong></p>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password" minlength="6"
                               id="password" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label for="txtRepetirSenha" class="form-label">Repeat new password</label>
                        <input type="password" class="form-control" name="password_confirmation"
                               id="txtRepetirSenha" equalTo="#password" autocomplete="off">
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

<script type="text/javascript">
    $(function () {
        let form = $('#formMyUser');

        $('#txtNome').focus();

        form.submit(function () {
            if (form.valid()) {
                $.request({
                    url: '/api/my-user',
                    method: 'PUT',
                    data: form.serialize(),
                    after: function () {
                        $.notify({message: 'Your information has been saved'}, {type: 'success'});
                        $('#modalAppMyUser').modal('hide');
                        $('#password, #txtRepetirSenha').val('');
                    }
                });
            }

            return false;
        });
    });
</script>
