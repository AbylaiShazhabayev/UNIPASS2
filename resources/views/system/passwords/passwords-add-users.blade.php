<div id="modalUsuariosDisponiveis" class="modal modal-blur fade" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add users</h5>
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
            <table id="tableUsuariosDisponiveis" class="table table-hover table-outline table-vcenter text-nowrap card-table w-100 border-top">
                <thead>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Permissions</th>
                </thead>
            </table>
            <div class="modal-footer">
                <button class="btn btn-white mr-auto w-xs" data-dismiss="modal">Cancel</button>
                <a href="javascript:void(0)" class="btn btn-primary w-xs disabled" id="btnUsuariosSalvar">Add</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $.getScript("{{ asset($assets . '/js/passwords-add-users.js?') . $version }}");
</script>
