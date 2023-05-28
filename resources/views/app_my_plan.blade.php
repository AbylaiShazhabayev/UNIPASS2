{{--<div id="modalAppMyPlan" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static"--}}
{{--     data-keyboard="false">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title">Meu plano</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"--}}
{{--                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"--}}
{{--                         stroke-linejoin="round">--}}
{{--                        <path stroke="none" d="M0 0h24v24H0z"></path>--}}
{{--                        <line x1="18" y1="6" x2="6" y2="18"></line>--}}
{{--                        <line x1="6" y1="6" x2="18" y2="18"></line>--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--            </div>--}}

{{--            <form id="formMyPlan" class="form-validation" role="form">--}}
{{--                <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

{{--                <div class="modal-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-6">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label class="form-label">Monthly value</label>--}}
{{--                                <div--}}
{{--                                    class="h1 my-3 planFree @if($tenant->active_users_limit > 1) d-none @endif">Plano--}}
{{--                                    gratuito--}}
{{--                                </div>--}}
{{--                                <div class="h1 my-3 planPaid @if($tenant->active_users_limit == 1) d-none @endif"><b>R$--}}
{{--                                        <span--}}
{{--                                            id="planAlteredPrice">{{ number_format($tenant->price, 2, ',', '.') }}</span></b>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-6">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label class="form-label">Number of users</label>--}}
{{--                                <div class="h1 my-3 planFree @if($tenant->active_users_limit > 1) d-none @endif">Até <b>1</b>--}}
{{--                                    usuário--}}
{{--                                </div>--}}
{{--                                <div class="h1 my-3 planPaid @if($tenant->active_users_limit == 1) d-none @endif">Até--}}
{{--                                    <b><span--}}
{{--                                            id="planAlteredUsers">{{ $tenant->active_users_limit }}</span></b> users--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row mt-6 justify-content-center">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="input-group mb-2">--}}
{{--                                <span class="input-group-text">Alterar quantidade de usuários:</span>--}}
{{--                                <input type="number" class="form-control w-9" name="active_users_limit"--}}
{{--                                       id="txtActiveUsersLimit"--}}
{{--                                       autocomplete="off" value="{{ $tenant->active_users_limit }}" required--}}
{{--                                       min="1"--}}
{{--                                       max="10000">--}}
{{--                                <span class="input-group-text">usuários</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="reset" class="btn btn-white mr-auto w-xs" data-dismiss="modal">Cancelar</button>--}}
{{--                    <button type="submit" class="btn btn-primary w-xs">Salvar</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<script>--}}
{{--    let form = $('#formMyPlan');--}}

{{--    $('#txtActiveUsersLimit').focus();--}}

{{--    form.submit(function () {--}}
{{--        if (form.valid()) {--}}
{{--            $.request({--}}
{{--                url: '/api/my-plan',--}}
{{--                method: 'PUT',--}}
{{--                data: form.serialize(),--}}
{{--                after: function () {--}}
{{--                    $.notify({message: 'As informações foram salvas'}, {type: 'success'});--}}
{{--                    $('#modalAppMyPlan').modal('hide');--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--        return false;--}}
{{--    });--}}

{{--    $('#txtActiveUsersLimit').change(function () {--}}
{{--        let usersCount = $(this).val();--}}

{{--        $('.planFree, .planPaid').addClass('d-none');--}}

{{--        if (usersCount == 1) {--}}
{{--            $('.planFree').removeClass('d-none');--}}
{{--        } else {--}}
{{--            $('.planPaid').removeClass('d-none');--}}
{{--            $('#planAlteredUsers').text(usersCount);--}}
{{--            $('#planAlteredPrice').text(number_format(calculatePrice(usersCount), 2, ',', '.'));--}}
{{--        }--}}
{{--    });--}}

{{--    function calculatePrice(usersCount) {--}}
{{--        if (usersCount === 1) {--}}
{{--            return 0;--}}
{{--        }--}}

{{--        if (usersCount <= 10) {--}}
{{--            return usersCount * 2.39;--}}
{{--        }--}}

{{--        if (usersCount <= 50) {--}}
{{--            return usersCount * 2.19;--}}
{{--        }--}}

{{--        return usersCount * 1.87;--}}
{{--    }--}}
{{--</script>--}}
